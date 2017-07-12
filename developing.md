# Developing on codame.com

## Set up workspace

### Installations

1. Download and install NodeJS
2. Download and install MAMP / MAMP Pro
3. Download codame-website repository and `npm install`
4. Install gulp globally by running `npm install gulp -g`
5. Run `gulp` to initialize the site in the `/dist` folder.

### Set up

1. Configure MAMP to serve the dist folder in the codame-website folder.
2. Replace `config/secrets-example.php` with the real secrets file, provided by an existing Codame developer.
3. In secrets.php replace the local URL with the actual URL of your local site

### Deployment

- All pushes to `master` automatically get deployed to http://dev.codame.com.
- Production pushes are manually triggered when the build on dev looks good.
