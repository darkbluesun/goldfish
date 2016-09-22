var goldfishServices = angular.module('goldfishServices', ['ngResource']);

goldfishServices.factory('Tasks', function($resource) {
  return $resource('/api/tasks/:id', { id: '@id' }, {
    update: {
      method: 'PUT'
    }
  });
});

goldfishServices.factory('Projects', function($resource) {
  return $resource('/api/projects/:id', { id: '@id' }, {
    update: {
      method: 'PUT'
    },
    get: {
      transformResponse: function(data) {
        data = angular.fromJson(data);
        data.due_date = data.due_date ? new Date(data.due_date) : null;
        return data;
      }
    }
  });
});

goldfishServices.factory('Clients', function($resource) {
  return $resource('/api/clients/:id', { id: '@id' }, {
    update: {
      method: 'PUT'
    }
  });
});

goldfishServices.factory('Users', function($resource) {
  return $resource('/api/users/:id', { id: '@id' }, {
    update: {
      method: 'PUT'
    }
  });
});