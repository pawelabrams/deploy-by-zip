# deploy-by-zip
It's crude. It's insecure. It works.

## How does it work?

It's a PHP 5.2 script (currently testing the min, but ZipArchive is 5.2+) to deploy github public repos to a shitty hosting that doesn't allow shell access. It's 100% pure PHP, so unless your server's op is a jerk and disables ZipArchive, you can push to deploy.

1. Copy deploy.php to your host and adjust repo's name and destination of unpacked files.
2. Go to https://github.com/{repo}/admin/hooks and select the Post-Receive URL service hook.
3. Enter the URL to deploy.php on your server (e.g. http://server.com/deploy.php ) and update settings.

Voila. Every commit on branch 'master' will now be pushed to deployment server. Use wisely.

## Known holes in reasoning

1. It pushes literally whole repo state on every update. Don't use on big projects.
2. Doesn't remove files when removed in repo.
3. Reserves deploy.php, deploy.zip and {destination}/{repo_basename}-master names for its use and will delete them when they're found.
4. (currently) Deploys only from master.
5. Can (D)DoS your server.
