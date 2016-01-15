/**
 * Created by smekkaoui on 21/05/2015.
 */
/**
 *
 * @param {string} bootstrap
 * @constructor
 */
var AjaxManager = function(bootstrap) {
    this.bootstrap = bootstrap;
    this.xhr       = new XMLHttpRequest();
};

AjaxManager.prototype.setDefaultErrorHandler = function(defaultErrorHandler) {
    this.defaultErrorHandler = defaultErrorHandler;
};

/**
 *
 * @param action
 * @param data
 * @param callback La fonction à appeler quand l'appel Ajax est OKAY
 * @param [callbackError] La fonction à appeler quand l'appel Ajax n'a pas fonctionné (Facultatif)
 * @param [caller] l'objet qui utilise l'ajaxManager le cas échéant
 * @returns {number}
 */
AjaxManager.prototype.send = function(controller, action, data, callback, callbackError, caller) {

    // Si data est en parametre, ce doit être un object. (Note: Null est object en js)
    if(data && typeof data != "object") {
        console.log("Format de données invalide : ",data);
        return 0;
    }
    var timeStamp = new Date();
    var dataString = "t="+timeStamp.getTime();

    if(data) {
        if(data.split) {
            for(var prop in data) {
                dataString += "&"+prop+"="+data[prop];
            }
        } else {
            dataString += "&data="+JSON.stringify(data);
        }
    }

    console.log("DATA", data);
    this.xhr.open("POST", this.bootstrap);
    this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    this.xhr.setRequestHeader("Connection", "close");
    var that = this;
    var xhr = this.xhr;

    this.xhr.onreadystatechange = function () {
        if(xhr.readyState === 4) {
            if(xhr.status == 200 ) {
                if(data && data.rawResponse) {
                    callback(xhr.responseText);
                    return;
                }

                try {
                    var response = new AjaxResponse(xhr.responseText);
                } catch (e) {
                    if(callbackError)
                    {
                        callbackError(e.message);
                    } else {
                        that.defaultErrorHandler(e.message, false);
                    }
                }


                if(response.success) {
                    callback(JSON.parse(xhr.responseText), caller);
                } else {
                    console.log("Erreur lors de la requête Ajax : ", response);
                    if(callbackError)
                    {
                        console.log("Apelle de la fonction de Callback");
                        callbackError(response.error);
                    } else {
                        that.defaultErrorHandler(response.error, false);
                    }
                }
            } else {
                console.log("[Erreur] Impossible d'avoir une réponse de ", that.bootstrap);
            }
        }
    };
    console.log("[POST] "+this.bootstrap, "[DATA} : ", dataString);
    this.xhr.send(dataString);
    return 1;
};

