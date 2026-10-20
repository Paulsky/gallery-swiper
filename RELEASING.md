# Building and releasing

Install the build dependencies once with `npm ci` (Node.js 22).

## Build a plugin zip locally

```sh
npm run plugin-zip
```

This creates `product-gallery-swiper-for-woocommerce.zip` with one top-level
`product-gallery-swiper-for-woocommerce/` directory, ready to install in WordPress.
The archive includes the plugin code, assets, translations, `README.txt`, license,
and Playground blueprint. Markdown files such as `README.md` and `CHANGELOG.md`
are excluded, together with development dependencies, build scripts, and Git files.
All source files remain in the repository.

`npm run deploy` formats the project and then creates the same archive.

## Publish a GitHub release

The examples below use `v1.8.0` and the `master` branch. Use the version you are
releasing. This procedure creates a new tag. If that tag already exists and the
release needs a fix before publication, use the recovery procedure below.

1. Update the version in `package.json`, both root version fields in
   `package-lock.json`, the plugin header and version constant in
   `wdevs-gallery-swiper.php`, and the stable tag in `README.txt`.
2. Add the version's changes to `CHANGELOG.md` and the changelog in `README.txt`.
3. Run a clean dependency installation before every release, then check the
   release notes and build the zip locally. This also checks that the lock file
   is complete and agrees with the dependency declarations:

   ```sh
   npm ci
   npm run release-notes -- v1.8.0
   npm run plugin-zip
   ```

4. Review and stage the intended release files. For the first automated release,
   include `.github/workflows/release.yml` and the `scripts/` directory in this
   commit. Check the staged changes with `git diff --cached`.
5. Commit the staged changes, push the branch, then create and push the tag.
   Run each command only after the previous command has succeeded:

   ```sh
   git commit -m "Added image limit setting and GitHub release workflow"
   git push origin master
   git tag v1.8.0
   git push origin v1.8.0
   ```

   Choose a commit message describing the changes for subsequent releases.

A tag points to an existing commit. It does not include uncommitted changes and
does not move when you make another commit. Committing or pushing `master` does
not start this release workflow: pushing the version tag is the trigger. The
tagged commit must contain the release workflow, build scripts, and plugin changes.

The **Release plugin** GitHub Actions workflow checks that the tag and versions
match, checks PHP syntax, and builds the zip. It then publishes a GitHub release
with the matching `CHANGELOG.md` entry as its release notes and attaches
`product-gallery-swiper-for-woocommerce.zip`.

Open the repository's **Actions** tab and check that **Release plugin** succeeds
for the tag. The release and installable zip then appear under **Releases**.

Use stable version tags in the form `vX.Y.Z`. GitHub Actions must be enabled for
the repository. The workflow uses its built-in `GITHUB_TOKEN`; no additional
secret is required. Re-running the workflow replaces the zip on an existing
release without changing its release notes.

## Recover an unpublished release

Use this procedure when a tag such as `v1.8.0` was pushed before the release
changes were committed, or when the release workflow failed and needs a code or
dependency fix. First complete steps 1–4 above so the release changes or fix are
tested and staged. Choose a commit message describing those changes.

The following Bash commands record the current local tag, commit and push the
release changes, and move the tag to that new commit. Run each command only after
the previous command has succeeded:

```bash
previous_release_tag=$(git rev-parse refs/tags/v1.8.0)
git commit -m "Fixed release build dependencies"
git push origin master
git tag -f v1.8.0
git push --force-with-lease="refs/tags/v1.8.0:$previous_release_tag" origin refs/tags/v1.8.0
```

The final push replaces the remote tag only if it still points to the tag
recorded in the first command. It stops if the remote tag differs. That tag push
triggers the release workflow for the new commit. Check the run under **Actions**.

If the release changes have already been committed and pushed, skip the commit
and branch-push commands. Re-running the old workflow run uses its original
commit, so it does not include a fix you have just pushed to `master`. Push the
corrected tag to run the workflow with that fix. Use a new version for changes
to an already published release.
