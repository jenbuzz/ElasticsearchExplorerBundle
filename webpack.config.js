var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('Resources/public/build/')
    .setPublicPath('/build')
    .addEntry('app', './Resources/assets/js/app.js')
    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
;

module.exports = Encore.getWebpackConfig();