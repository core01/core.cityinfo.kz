(function () {

  var laroute = (function () {

    var routes = {

      absolute: false,
      rootUrl: 'http://core.cityinfo.dev',
      routes: [{
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': '\/',
        'name': 'main',
        'action': 'Closure'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'login',
        'name': 'login',
        'action': 'App\Http\Controllers\Auth\LoginController@showLoginForm'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'login',
        'name': 'login.post',
        'action': 'App\Http\Controllers\Auth\LoginController@login'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'logout',
        'name': 'logout',
        'action': 'App\Http\Controllers\Auth\LoginController@logout'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'register',
        'name': 'register',
        'action': 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'register',
        'name': 'register.post',
        'action': 'App\Http\Controllers\Auth\RegisterController@register'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'password\/reset',
        'name': 'password.reset',
        'action': 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'password\/email',
        'name': 'password.email',
        'action': 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'password\/reset\/{token}',
        'name': 'password.reset.token',
        'action': 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'password\/reset',
        'name': 'password.reset.post',
        'action': 'App\Http\Controllers\Auth\ResetPasswordController@reset'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'manager',
        'name': 'manager',
        'action': 'App\Http\Controllers\ManagerController@index'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'profile',
        'name': 'profile',
        'action': 'App\Http\Controllers\ProfileController@index'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'manager\/company-meta',
        'name': 'manager.company.meta',
        'action': 'App\Http\Controllers\ManagerController@renderCompanyMeta'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'profile',
        'name': 'profile.save',
        'action': 'App\Http\Controllers\ProfileController@save'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'api\/image',
        'name': 'image.upload',
        'action': 'App\Http\Controllers\UploadController@uploadImage'
      }, {
        'host': null,
        'methods': ['DELETE'],
        'uri': 'api\/image',
        'name': 'image.delete',
        'action': 'App\Http\Controllers\UploadController@deleteImage'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'manager\/getCompanyMeta',
        'name': 'manager.get.company.meta',
        'action': 'App\Http\Controllers\ManagerController@getCompanyMeta'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'manager\/saveCompanyMeta',
        'name': 'manager.save.company.meta',
        'action': 'App\Http\Controllers\ManagerController@saveCompanyMeta'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'manager\/users',
        'name': 'manager.users',
        'action': 'App\Http\Controllers\ManagerController@renderUsers'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'manager\/user\/save',
        'name': 'manager.user.save',
        'action': 'App\Http\Controllers\ManagerController@saveUser'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'manager\/role\/save',
        'name': 'manager.role.save',
        'action': 'App\Http\Controllers\ManagerController@saveRole'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'manager\/role\/permissions',
        'name': 'get.role.permissions',
        'action': 'App\Http\Controllers\ManagerController@getRolePermissions'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'manager\/role\/create',
        'name': 'manager.role.create',
        'action': 'App\Http\Controllers\ManagerController@createRole'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'manager\/role\/delete',
        'name': 'manager.role.delete',
        'action': 'App\Http\Controllers\ManagerController@deleteRole'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'api\/permissions',
        'name': 'get.all.permissions',
        'action': 'App\Http\Controllers\PermissionController@getAll'
      }, {
        'host': null,
        'methods': ['POST'],
        'uri': 'api\/permission\/{id}',
        'name': 'save.permission',
        'action': 'App\Http\Controllers\PermissionController@save'
      }, {
        'host': null,
        'methods': ['PUT'],
        'uri': 'api\/permissions',
        'name': 'add.permission',
        'action': 'App\Http\Controllers\PermissionController@add'
      }, {
        'host': null,
        'methods': ['DELETE'],
        'uri': 'api\/permissions\/{id}',
        'name': 'delete.permission',
        'action': 'App\Http\Controllers\PermissionController@delete'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'api\/users',
        'name': 'get.users',
        'action': 'App\Http\Controllers\UserController@getAll'
      }, {
        'host': null,
        'methods': ['GET', 'HEAD'],
        'uri': 'api\/roles',
        'name': 'get.roles',
        'action': 'App\Http\Controllers\RoleController@getAll'
      }],
      prefix: '',

      route: function (name, parameters, route) {
        route = route || this.getByName(name);

        if (!route) {
          return undefined;
        }

        return this.toRoute(route, parameters);
      },

      url: function (url, parameters) {
        parameters = parameters || [];

        var uri = url + '/' + parameters.join('/');

        return this.getCorrectUrl(uri);
      },

      toRoute: function (route, parameters) {
        var uri = this.replaceNamedParameters(route.uri, parameters);
        var qs = this.getRouteQueryString(parameters);

        if (this.absolute && this.isOtherHost(route)) {
          return '//' + route.host + '/' + uri + qs;
        }

        return this.getCorrectUrl(uri + qs);
      },

      isOtherHost: function (route) {
        return route.host && route.host != window.location.hostname;
      },

      replaceNamedParameters: function (uri, parameters) {
        uri = uri.replace(/\{(.*?)\??\}/g, function (match, key) {
          if (parameters.hasOwnProperty(key)) {
            var value = parameters[key];
            delete parameters[key];
            return value;
          } else {
            return match;
          }
        });

        // Strip out any optional parameters that were not given
        uri = uri.replace(/\/\{.*?\?\}/g, '');

        return uri;
      },

      getRouteQueryString: function (parameters) {
        var qs = [];
        for (var key in parameters) {
          if (parameters.hasOwnProperty(key)) {
            qs.push(key + '=' + parameters[key]);
          }
        }

        if (qs.length < 1) {
          return '';
        }

        return '?' + qs.join('&');
      },

      getByName: function (name) {
        for (var key in this.routes) {
          if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
            return this.routes[key];
          }
        }
      },

      getByAction: function (action) {
        for (var key in this.routes) {
          if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
            return this.routes[key];
          }
        }
      },

      getCorrectUrl: function (uri) {
        var url = this.prefix + '/' + uri.replace(/^\/?/, '');

        if (!this.absolute) {
          return url;
        }

        return this.rootUrl.replace('/\/?$/', '') + url;
      }
    };

    var getLinkAttributes = function (attributes) {
      if (!attributes) {
        return '';
      }

      var attrs = [];
      for (var key in attributes) {
        if (attributes.hasOwnProperty(key)) {
          attrs.push(key + '="' + attributes[key] + '"');
        }
      }

      return attrs.join(' ');
    };

    var getHtmlLink = function (url, title, attributes) {
      title = title || url;
      attributes = getLinkAttributes(attributes);

      return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
    };

    return {
      // Generate a url for a given controller action.
      // routes.action('HomeController@getIndex', [params = {}])
      action: function (name, parameters) {
        parameters = parameters || {};

        return routes.route(name, parameters, routes.getByAction(name));
      },

      // Generate a url for a given named route.
      // routes.route('routeName', [params = {}])
      route: function (route, parameters) {
        parameters = parameters || {};

        return routes.route(route, parameters);
      },

      // Generate a fully qualified URL to the given path.
      // routes.route('url', [params = {}])
      url: function (route, parameters) {
        parameters = parameters || {};

        return routes.url(route, parameters);
      },

      // Generate a html link to the given url.
      // routes.link_to('foo/bar', [title = url], [attributes = {}])
      link_to: function (url, title, attributes) {
        url = this.url(url);

        return getHtmlLink(url, title, attributes);
      },

      // Generate a html link to the given route.
      // routes.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
      link_to_route: function (route, title, parameters, attributes) {
        var url = this.route(route, parameters);

        return getHtmlLink(url, title, attributes);
      },

      // Generate a html link to the given controller action.
      // routes.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
      link_to_action: function (action, title, parameters, attributes) {
        var url = this.action(action, parameters);

        return getHtmlLink(url, title, attributes);
      }

    };

  }).call(this);

  /**
   * Expose the class either via AMD, CommonJS or the global object
   */
  if (typeof define === 'function' && define.amd) {
    define(function () {
      return laroute;
    });
  }
  else if (typeof module === 'object' && module.exports) {
    module.exports = laroute;
  }
  else {
    window.routes = laroute;
  }

}).call(this);

