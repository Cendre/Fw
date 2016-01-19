var jsFolder = '/app/js';

requirejs.config({
    baseUrl: jsFolder+'',
    paths: {
        proto: jsFolder+'/proto/',
        lib: jsFolder+'/lib/'
    }
});

require(['main']);