(function(){var t=function(){var t={absolute:!1,rootUrl:"http://core.cityinfo.dev",routes:[{host:null,methods:["GET","HEAD"],uri:"/",name:"main",action:"Closure"},{host:null,methods:["GET","HEAD"],uri:"login",name:"login",action:"AppHttpControllersAuthLoginController@showLoginForm"},{host:null,methods:["POST"],uri:"login",name:"login.post",action:"AppHttpControllersAuthLoginController@login"},{host:null,methods:["POST"],uri:"logout",name:"logout",action:"AppHttpControllersAuthLoginController@logout"},{host:null,methods:["GET","HEAD"],uri:"register",name:"register",action:"AppHttpControllersAuthRegisterController@showRegistrationForm"},{host:null,methods:["POST"],uri:"register",name:"register.post",action:"AppHttpControllersAuthRegisterController@register"},{host:null,methods:["GET","HEAD"],uri:"password/reset",name:"password.reset",action:"AppHttpControllersAuthForgotPasswordController@showLinkRequestForm"},{host:null,methods:["POST"],uri:"password/email",name:"password.email",action:"AppHttpControllersAuthForgotPasswordController@sendResetLinkEmail"},{host:null,methods:["GET","HEAD"],uri:"password/reset/{token}",name:"password.reset.token",action:"AppHttpControllersAuthResetPasswordController@showResetForm"},{host:null,methods:["POST"],uri:"password/reset",name:"password.reset.post",action:"AppHttpControllersAuthResetPasswordController@reset"},{host:null,methods:["GET","HEAD"],uri:"manager",name:"manager",action:"AppHttpControllersManagerController@index"},{host:null,methods:["GET","HEAD"],uri:"profile",name:"profile",action:"AppHttpControllersProfileController@index"},{host:null,methods:["GET","HEAD"],uri:"manager/company-meta",name:"manager.company.meta",action:"AppHttpControllersManagerController@renderCompanyMeta"},{host:null,methods:["POST"],uri:"profile",name:"profile.save",action:"AppHttpControllersProfileController@save"},{host:null,methods:["GET","HEAD"],uri:"user/permissions",name:"get.user.permissions",action:"AppHttpControllersUserController@getPermissions"},{host:null,methods:["GET","HEAD"],uri:"manager/getCompanyMeta",name:"manager.get.company.meta",action:"AppHttpControllersManagerController@getCompanyMeta"},{host:null,methods:["POST"],uri:"manager/saveCompanyMeta",name:"manager.save.company.meta",action:"AppHttpControllersManagerController@saveCompanyMeta"},{host:null,methods:["GET","HEAD"],uri:"manager/users",name:"manager.users",action:"AppHttpControllersManagerController@renderUsers"},{host:null,methods:["POST"],uri:"manager/user/save",name:"manager.user.save",action:"AppHttpControllersManagerController@saveUser"},{host:null,methods:["POST"],uri:"manager/role/save",name:"manager.role.save",action:"AppHttpControllersManagerController@saveRole"},{host:null,methods:["GET","HEAD"],uri:"manager/role/permissions",name:"get.role.permissions",action:"AppHttpControllersManagerController@getRolePermissions"},{host:null,methods:["POST"],uri:"manger/role/create",name:"manager.role.create",action:"AppHttpControllersManagerController@createRole"},{host:null,methods:["POST"],uri:"manger/role/delete",name:"manager.role.delete",action:"AppHttpControllersManagerController@deleteRole"}],prefix:"",route:function(t,e,r){if(r=r||this.getByName(t))return this.toRoute(r,e)},url:function(t,e){e=e||[];var r=t+"/"+e.join("/");return this.getCorrectUrl(r)},toRoute:function(t,e){var r=this.replaceNamedParameters(t.uri,e),o=this.getRouteQueryString(e);return this.absolute&&this.isOtherHost(t)?"//"+t.host+"/"+r+o:this.getCorrectUrl(r+o)},isOtherHost:function(t){return t.host&&t.host!=window.location.hostname},replaceNamedParameters:function(t,e){return t=t.replace(/\{(.*?)\??\}/g,function(t,r){if(e.hasOwnProperty(r)){var o=e[r];return delete e[r],o}return t}),t=t.replace(/\/\{.*?\?\}/g,"")},getRouteQueryString:function(t){var e=[];for(var r in t)t.hasOwnProperty(r)&&e.push(r+"="+t[r]);return e.length<1?"":"?"+e.join("&")},getByName:function(t){for(var e in this.routes)if(this.routes.hasOwnProperty(e)&&this.routes[e].name===t)return this.routes[e]},getByAction:function(t){for(var e in this.routes)if(this.routes.hasOwnProperty(e)&&this.routes[e].action===t)return this.routes[e]},getCorrectUrl:function(t){var e=this.prefix+"/"+t.replace(/^\/?/,"");return this.absolute?this.rootUrl.replace("//?$/","")+e:e}},e=function(t){if(!t)return"";var e=[];for(var r in t)t.hasOwnProperty(r)&&e.push(r+'="'+t[r]+'"');return e.join(" ")},r=function(t,r,o){return r=r||t,o=e(o),'<a href="'+t+'" '+o+">"+r+"</a>"};return{action:function(e,r){return r=r||{},t.route(e,r,t.getByAction(e))},route:function(e,r){return r=r||{},t.route(e,r)},url:function(e,r){return r=r||{},t.url(e,r)},link_to:function(t,e,o){return t=this.url(t),r(t,e,o)},link_to_route:function(t,e,o,n){var s=this.route(t,o);return r(s,e,n)},link_to_action:function(t,e,o,n){var s=this.action(t,o);return r(s,e,n)}}}.call(this);"function"==typeof define&&define.amd?define(function(){return t}):"object"==typeof module&&module.exports?module.exports=t:window.routes=t}).call(this);