angular.module('estadium', ['ionic', 'estadium.controllers', 'estadium.services', 'estadium.object_utils'])

//.constant('host', 'http://estadium.gatech.edu')
.constant('host','')

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.config(function($sceDelegateProvider) {
    $sceDelegateProvider.resourceUrlWhitelist(['**']);
})

.config(function ($ionicConfigProvider) {
        $ionicConfigProvider.views.maxCache(0);
    })

.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider

  .state('app', {
    url: "/app",
    abstract: true,
    templateUrl: "templates/menu.html",
    controller: 'AppCtrl'
  })

  .state('app.homepage', {
    url: "/homepage",
    views: {
      'menuContent': {
        templateUrl: "templates/homepage.html",
        controller: "HomepageCtrl"
      }
    }
  })

  .state('app.team-stats', {
          url: '/team-stats',
          views: {
              'menuContent': {
                  templateUrl: "templates/team-stats.html",
                  controller: "TeamStatsCtrl"
              }
          }
    }
  )

      .state('app.offense', {
          url: '/offense',
          views: {
              'menuContent': {
                  templateUrl: "templates/offense.html",
                  controller: "OffenseCtrl"
              }
          }
      }
  )

      .state('app.defense', {
          url: '/defense',
          views: {
              'menuContent': {
                  templateUrl: "templates/defense.html",
                  controller: "DefenseCtrl"
              }
          }
      }
  )
      .state('app.special-teams', {
          url: '/special-teams',
          views: {
              'menuContent': {
                  templateUrl: "templates/special-teams.html",
                  controller: "SpecialTeamsCtrl"
              }
          }
      }
  )

      .state('app.play-by-play', {
          url: '/play-by-play',
          views: {
              'menuContent': {
                  templateUrl: "templates/play-by-play.html",
                  controller: "PlayByPlayCtrl"
              }
          }
      })

      .state('app.popular-play', {
          url: '/popular-play',
          views: {
              'menuContent': {
                  templateUrl: "templates/popular-play.html",
                  controller: "PopularPlayCtrl"
              }
          }
      })

          .state('app.drive-tracker', {
              url: '/drive-tracker',
              views: {
                  'menuContent': {
                      templateUrl: "templates/drive-tracker.html",
                      controller: "DriveTrackerCtrl"
                  }
              }
          }
  );

  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/app/homepage');
});
