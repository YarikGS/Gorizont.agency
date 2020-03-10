function initMap() {
    var e = horizontOffice = {
      lat: 55.174445,
      lng: 61.410461
    },
    t = 16;
    window.innerWidth < 992 && (e = {
      lat: 55.175493,
      lng: 61.410461
    }, t = 14);
    var n = new google.maps.Map(document.getElementById('map'), {
      zoom: t,
      center: e,
      disableDefaultUI: !0,
      styles: [
        {
          featureType: 'all',
          elementType: 'all',
          stylers: [
            {
              lightness: '29'
            },
            {
              invert_lightness: !0
            },
            {
              hue: '#008fff'
            },
            {
              saturation: '-73'
            }
          ]
        },
        {
          featureType: 'all',
          elementType: 'labels',
          stylers: [
            {
              saturation: '-72'
            }
          ]
        },
        {
          featureType: 'administrative',
          elementType: 'all',
          stylers: [
            {
              lightness: '32'
            },
            {
              weight: '0.42'
            }
          ]
        },
        {
          featureType: 'administrative',
          elementType: 'labels',
          stylers: [
            {
              visibility: 'on'
            },
            {
              lightness: '-53'
            },
            {
              saturation: '-66'
            }
          ]
        },
        {
          featureType: 'landscape',
          elementType: 'all',
          stylers: [
            {
              lightness: '-86'
            },
            {
              gamma: '1.13'
            }
          ]
        },
        {
          featureType: 'landscape',
          elementType: 'geometry.fill',
          stylers: [
            {
              hue: '#006dff'
            },
            {
              lightness: '4'
            },
            {
              gamma: '1.44'
            },
            {
              saturation: '-67'
            }
          ]
        },
        {
          featureType: 'landscape',
          elementType: 'geometry.stroke',
          stylers: [
            {
              lightness: '5'
            }
          ]
        },
        {
          featureType: 'landscape',
          elementType: 'labels.text.fill',
          stylers: [
            {
              visibility: 'off'
            }
          ]
        },
        {
          featureType: 'poi',
          elementType: 'all',
          stylers: [
            {
              visibility: 'off'
            }
          ]
        },
        {
          featureType: 'poi',
          elementType: 'labels.text.fill',
          stylers: [
            {
              weight: '0.84'
            },
            {
              gamma: '0.5'
            }
          ]
        },
        {
          featureType: 'poi',
          elementType: 'labels.text.stroke',
          stylers: [
            {
              visibility: 'off'
            },
            {
              weight: '0.79'
            },
            {
              gamma: '0.5'
            }
          ]
        },
        {
          featureType: 'road',
          elementType: 'all',
          stylers: [
            {
              visibility: 'simplified'
            },
            {
              lightness: '-78'
            },
            {
              saturation: '-91'
            }
          ]
        },
        {
          featureType: 'road',
          elementType: 'labels.text',
          stylers: [
            {
              color: '#ffffff'
            },
            {
              lightness: '-69'
            }
          ]
        },
        {
          featureType: 'road.highway',
          elementType: 'geometry.fill',
          stylers: [
            {
              lightness: '5'
            }
          ]
        },
        {
          featureType: 'road.arterial',
          elementType: 'geometry.fill',
          stylers: [
            {
              lightness: '10'
            },
            {
              gamma: '1'
            }
          ]
        },
        {
          featureType: 'road.local',
          elementType: 'geometry.fill',
          stylers: [
            {
              lightness: '10'
            },
            {
              saturation: '-100'
            }
          ]
        },
        {
          featureType: 'transit',
          elementType: 'all',
          stylers: [
            {
              lightness: '-35'
            }
          ]
        },
        {
          featureType: 'transit',
          elementType: 'labels.text.stroke',
          stylers: [
            {
              visibility: 'off'
            }
          ]
        },
        {
          featureType: 'water',
          elementType: 'all',
          stylers: [
            {
              saturation: '-97'
            },
            {
              lightness: '-14'
            }
          ]
        }
      ]
    });
    var r = {
      url: './assets/img/marker.svg',
      size: new google.maps.Size(47, 70),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(23, 70)
    };
    new google.maps.Marker({
      position: horizontOffice,
      map: n,
      icon: r
    }).setMap(n)
}

$(".owl-carousel").owlCarousel({
    items: 1,
    nav: true,
    smartSpeed: 700,
    loop: true,
    dots: false
});

new WOW().init();
