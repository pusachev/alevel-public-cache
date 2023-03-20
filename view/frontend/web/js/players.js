define([
    'uiComponent',
    'jquery',
],function(uiComponent, $) {
    'use strict';

    return uiComponent.extend({
        user: "Petya",
        age: "21",
        phone: "1234567890",

        getUsers: function () {
            return this.users;
        },

        hello: function () {
            return "Hello " + this.user;
        }
    });
});
