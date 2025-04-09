#!/bin/sh

set -e

# Root directory.
BASEDIR=$( cd `dirname $0`/.. ; pwd )
cd "$BASEDIR"

docker build -t adminneo:devel --build-arg CACHE_BUST="$(date +%s)" docker

docker stop adminneo || true
docker rm adminneo || true

docker run -d --name adminneo -p 8080:80 \
  -e ADMINNEO_COLOR_VARIANT=green \
  -e ADMINNEO_PREFER_SELECTION=true \
  -e ADMINNEO_JSON_VALUES_DETECTION=true \
  -e ADMINNEO_JSON_VALUES_AUTO_FORMAT=true \
  -e ADMINNEO_DEFAULT_PASSWORD_HASH= \
  -e ADMINNEO_SSL_TRUST_SERVER_CERTIFICATE=true \
  adminneo:devel
