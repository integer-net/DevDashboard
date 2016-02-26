#!/bin/bash
set -e
set -x


function cleanup {
  if [ -z $SKIP_CLEANUP ]; then
    echo "Removing build directory ${BUILDENV}"
    rm -rf "${BUILDENV}"
  fi
}

trap cleanup EXIT

# check if this is a travis environment
if [ ! -z $TRAVIS_BUILD_DIR ] ; then
  WORKSPACE=$TRAVIS_BUILD_DIR
fi

if [ -z $WORKSPACE ] ; then
  echo "No workspace configured, please set your WORKSPACE environment"
  exit
fi

BUILDENV=`mktemp -d /tmp/mageteststand.XXXXXXXX`

echo "Using build directory ${BUILDENV}"

git clone https://github.com/schmengler/MageTestStand.git "${BUILDENV}"
cp -rf "${WORKSPACE}" "${BUILDENV}/.modman/"
cp -rf ${WORKSPACE}/.modman/* "${BUILDENV}/.modman/"
cp -f ${WORKSPACE}/composer.lock "${BUILDENV}/"
mkdir "${BUILDENV}/.modman/composer"
cp -rf ${WORKSPACE}/vendor "${BUILDENV}/.modman/composer/"
echo "vendor vendor" > "${BUILDENV}/.modman/composer/modman"
${BUILDENV}/install.sh

cd ${BUILDENV}/htdocs
${BUILDENV}/htdocs/vendor/bin/phpunit --colors -d display_errors=1

