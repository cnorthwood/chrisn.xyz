# chrisn.xyz

Developer Information
---------------------

This codebase is WordPress based, and uses [Bedrock](https://roots.io/bedrock/) as the foundation.

To update WordPress and plugin versions, you will need [Composer](https://getcomposer.org/) installed
and then run `composer upgrade`. You can use [wpackagist](https://wpackagist.org/)
to install additional WordPress plugins.

To create a local dev environment, you will need Docker installed locally.

* `docker-compose up`
* You will now be able to see the site at http://localhost:8080/.

Deployment Information
----------------------

This is deployed on Chris's server. There's a systemd unitfile that looks like this
at `/etc/systemd/system/chrisnxyz.service`

```ini
[Unit]
Description=chrisn.xyz
After=docker.service
Requires=docker.service

[Service]
EnvironmentFile=/etc/chrisnxyz.conf
ExecStartPre=-/bin/sh -c 'docker rm -f chrisnxyz >/dev/null 2>/dev/null'
ExecStartPre=-/bin/sh -c 'docker pull ghcr.io/cnorthwood/chrisn.xyz:${image_version} >/dev/null'
ExecStart=/usr/bin/docker run --init --rm \
                              --env-file /etc/chrisnxyz.conf \
                              -p 8080:8080 \
                              --add-host=host.docker.internal:host-gateway \
                              --mount type=volume,source=chrisnxyz-uploads,target=/app/web/app/uploads/ \
                              --name chrisnxyz \
                              ghcr.io/cnorthwood/chrisn.xyz:${image_version}
ExecStop=/bin/sh -c 'docker stop chrisnxyz >/dev/null'

[Install]
WantedBy=multi-user.target
```

The config file at `/etc/chrisn.xyz` has the environment variables needed to run this.

There's an nginx running on my server which reverse proxies to this docker file.

```
server {
    listen 80;
    listen [::]:80;
    listen 443 ssl http2;
    listen [::]:443 ssl http2;

    ssl_certificate /etc/letsencrypt/live/chrisn.xyz/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/chrisn.xyz/privkey.pem;
    add_header Strict-Transport-Security "max-age=31536000" always;

    server_name chrisn.xyz;

    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Forwarded-For $remote_addr;
    }

    location /.well-known/ {
        root /var/www/html;
    }

    if ($ssl_protocol = "") {
       rewrite ^   https://$server_name$request_uri? permanent;
    }
}
```
