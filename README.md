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

The site runs on the [coven](https://github.com/omelette-gay/coven) k3s cluster, in the `chrisn-xyz` namespace.

Every push to `main` builds an image, pushes it to `ghcr.io/cnorthwood/chrisn.xyz`, and deploys it with
`helm upgrade` using the chart in `charts/chrisn-xyz` and the values in `charts/chrisn-xyz/values/coven.yml`
(see `.github/workflows/deploy.yml`). The workflow logs in to the cluster through Vault, and deploys roll
without downtime.

The chart runs WordPress and its MariaDB database (through the MariaDB operator, with nightly backups to GCS).
Everything else comes from coven, in `coven/apps/chrisn-xyz.tf`:

* the namespace, and the Vault role the deploy workflow uses
* the `wordpress` Secret, with WordPress's keys and salts, synced from Vault (`chrisn-xyz/wordpress`)
* the `gcp-backups` Secret, with the credentials for the database backups
* the object store for media uploads

Media uploads are stored in the `app` bucket of that object store by the
[S3 Uploads](https://github.com/humanmade/S3-Uploads) plugin, and served from
`https://media.chrisn.xyz/app/uploads/...`. Old links to `https://chrisn.xyz/app/uploads/...` redirect there.
Without a bucket configured, as in the local dev environment, uploads stay on disk.
