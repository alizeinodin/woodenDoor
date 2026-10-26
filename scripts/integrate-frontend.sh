#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
FRONTEND_DIR="${ROOT_DIR}/frontend"
PUBLIC_URL_PREFIX="${PUBLIC_URL_PREFIX:-/jobvision}"

echo "==> Cloning / updating frontend"
if [ -d "${FRONTEND_DIR}/.git" ]; then
  git -C "${FRONTEND_DIR}" fetch --depth 1 origin master
  git -C "${FRONTEND_DIR}" reset --hard origin/master
else
  rm -rf "${FRONTEND_DIR}"
  git clone --depth 1 -b master https://github.com/asmachegeni/WoodenDoor.git "${FRONTEND_DIR}"
fi

echo "==> Patching frontend for Laravel subdirectory deploy"
# homepage for CRA asset paths
if grep -q '"homepage"' "${FRONTEND_DIR}/package.json"; then
  sed -i 's|"homepage": *"[^"]*"|"homepage": "'"${PUBLIC_URL_PREFIX}"'"|' "${FRONTEND_DIR}/package.json"
else
  sed -i 's|"private": true,|"private": true,\n  "homepage": "'"${PUBLIC_URL_PREFIX}"'",|' "${FRONTEND_DIR}/package.json"
fi

# Axios base URL + path prefix interceptor
cat > "${FRONTEND_DIR}/src/component/BaseUrl.jsx" <<'EOF'
import axios from "axios";

const APP_PREFIX = "/jobvision";

const AxiosUrl = axios.create({
  baseURL: "",
  withCredentials: true,
  headers: {
    Accept: "application/json",
  },
});

AxiosUrl.interceptors.request.use((config) => {
  if (typeof config.url === "string" && config.url.startsWith("/")) {
    config.url = `${APP_PREFIX}${config.url}`;
  }
  return config;
});

export default AxiosUrl;
EOF

# BrowserRouter basename
python3 - <<PY
from pathlib import Path
path = Path("${FRONTEND_DIR}/src/App.js")
text = path.read_text()
if "basename=" not in text:
    text = text.replace(
        "<Router>",
        '<Router basename="/jobvision">',
        1,
    )
    path.write_text(text)
    print("Added Router basename")
else:
    print("Router basename already present")
PY

echo "==> Installing npm deps and building"
cd "${FRONTEND_DIR}"
if [ -s "$HOME/.nvm/nvm.sh" ]; then
  # shellcheck disable=SC1090
  . "$HOME/.nvm/nvm.sh"
fi
npm ci --legacy-peer-deps
PUBLIC_URL="${PUBLIC_URL_PREFIX}" npm run build

echo "==> Copying build into Laravel public/"
cd "${ROOT_DIR}"
rm -rf public/static
cp -a frontend/build/static public/static
cp -f frontend/build/asset-manifest.json public/asset-manifest.json
cp -f frontend/build/manifest.json public/manifest.json 2>/dev/null || true
cp -f frontend/build/favicon.ico public/favicon.ico 2>/dev/null || true
# copy other root assets except index.html (served via Blade)
find frontend/build -maxdepth 1 -type f ! -name 'index.html' -exec cp -f {} public/ \;

echo "==> Frontend integrated into Laravel views/public"
