# apache-docker
a custom Docker image to run PHP with apache server

## Features
- apache with php
- rewrite module
- max upload and post size: 1024mb
- easy to install php extensions
- ttyd shell access
- web file manager

## Build
```
docker build --build-arg PKGS="screen fish neofetch" -t apache .
```
`PKGS` default: ""

## Run
```
docker run -e TTYD_AUTH="user:pass" -p 80:80 apache
```
`PKGTTYD_AUTHS` default: "admin:1234" 

## Notes
- put web files on `htdocs` folder.
- please check `Dockerfile` to setup linux packages and php extensions.
- 
- `TTYD_AUTH` is the user pass of the ttyd shell, you can access it by visiting `http(s)://<ip or hostname>/admin` in your browser.