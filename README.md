# apache-docker
a custom Docker image to run apache server with PHP and ttyd web shell.

## Features
- apache with php
- rewrite module
- max upload and post size: 1024mb
- easy to install php extensions
- ttyd shell access
- web file manager

## Build
download or clone this repo then cd into it`s folder and run this command :
```
docker build \
  --build-arg PKGS="screen fish neofetch" \
  --build-arg EXTS="swoole redis" \
  -t apache:ttyd .
```
> `PKGS` default: ""

> `EXTS` default: ""

## Run
once the image is ready run this command :
```
docker run -e TTYD_AUTH="user:pass" -p 80:80 apache:ttyd
```
> `TTYD_AUTH` default: "admin:1234" 

## Notes
- put web files on `htdocs` folder.
- please check `Dockerfile` to setup linux packages and php extensions.
- `PKGS` used to install more linux packages when you build the image.
- `EXTS` used to install more php extensions when you build the image.
- `TTYD_AUTH` is the user and pass of ttyd shell, you can access it by visiting `http(s)://<ip or hostname>/admin` in your browser, you can change shell path in the `server/site.conf` file as you wish.