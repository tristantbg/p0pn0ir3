/* jshint esversion: 6 */

import 'babel-polyfill'
import lazysizes from 'lazysizes'
import optimumx from 'lazysizes'
require('../../node_modules/lazysizes/plugins/object-fit/ls.object-fit.js')
require('../../node_modules/lazysizes/plugins/unveilhooks/ls.unveilhooks.js')
import Amplitude from 'amplitudejs'
import imagesLoaded from 'imagesloaded'
// import Packery from 'packery'
import InfiniteGrid, {
  FrameLayout
} from "@egjs/infinitegrid";
import IScroll from 'iscroll'
import Hls from 'hls.js'
import throttle from 'lodash.throttle'
// import {
//   TweenMax,
//   AttrPlugin
// } from 'gsap'
import Barba from 'barba.js'


function addListenerMulti(el, s, fn) {
  s.split(' ').forEach(e => el.addEventListener(e, fn, false));
}

const getUrlParams = prop => {
  var params = {};
  var search = decodeURIComponent(window.location.href.slice(window.location.href.indexOf('?') + 1));
  var definitions = search.split('&');

  definitions.forEach(function(val, key) {
    var parts = val.split('=', 2);
    params[parts[0]] = parts[1];
  });

  return (prop && prop in params) ? params[prop] : params;
}

const simulateClick = elem => {
  // Create our event (with options)
  var evt = new MouseEvent('click', {
    bubbles: true,
    cancelable: true,
    view: window
  });
  // If cancelled, don't dispatch our event
  var canceled = !elem.dispatchEvent(evt);
}

const resizeWindow = () => {
  var event = document.createEvent('HTMLEvents');
  event.initEvent('resize', true, false);
  window.dispatchEvent(event);
}

const sizeElem = (id, sizeW, sizeH) => {
  const elem = document.getElementById(id)
  if (elem) {
    if (sizeW) elem.style.width = sizeW + 'px'
    if (sizeH) elem.style.height = sizeH + 'px'
  }
}

const placeElem = (id, top, left) => {
  const elem = document.getElementById(id)
  if (elem) {
    if (top) elem.style.top = top + 'px'
    if (left) elem.style.left = left + 'px'
  }
}

const margeElem = (id, top) => {
  const elem = document.getElementById(id)
  if (elem) {
    if (top) elem.style.marginTop = top + 'px'
  }
}

const App = {
  init: () => {
    App.pageType = document.body.getAttribute('page-type');
    App.sizeSet()
    App.hiddenNav.init()
    App.interact.init()
    window.addEventListener('resize', throttle(App.sizeSet, 128), false);
    document.getElementById('loader').style.display = 'none'
    App.intro.init()

    document.addEventListener('click', e => {
      if (
        e.target.getAttribute('event-target') !== 'about-panel' && document.body.classList.contains('about-panel') && !App.aboutPanel.contains(e.target) ||
        e.target.getAttribute('event-target') === 'about-panel' && document.body.classList.contains('about-panel') && App.aboutPanel.contains(e.target)) document.body.classList.remove('about-panel')
    })

    document.addEventListener('lazybeforeunveil', Scroller.refresh);
  },
  sizeSet: () => {
    App.width = (window.innerWidth || document.documentElement.clientWidth);
    App.height = (window.innerHeight || document.documentElement.clientHeight);
    if (App.width <= 767)
      App.isMobile = true;
    if (App.isMobile) {
      if (App.width > 767) {
        // location.reload();
        App.isMobile = false;
      }
    }
    App.setElements();
  },
  setElements: () => {
    App.header = document.querySelector('header')
    App.menu = document.getElementById('menu')
    App.aboutPanel = document.getElementById('about-panel')
    // if (!App.isMobile) {
    //   const elem = document.querySelector('#artist-releases .inner-scroll')
    //   if (elem) {
    //     let sizeW = 16
    //     elem.querySelectorAll('.release').forEach(elem => {
    //       sizeW += Math.floor(elem.offsetWidth + parseInt(getComputedStyle(elem).marginRight))
    //     })
    //     if (sizeW) elem.style.width = sizeW + 'px'
    //   }
    // }

  },
  intro: {
    init: () => {
      const intro = document.getElementById('intro')
      if (intro) {

        if (App.intro.localstorage.load('intro')) {
          intro.style.display = 'none'
        } else {

          intro.classList.add('show')
          setTimeout(function() {
            intro.classList.add('animate')
            setTimeout(function() {
              intro.classList.add('hide')
            }, 2000);
          }, 800);

          intro.addEventListener('click', () => {
            intro.classList.add('hide')
          })

          App.intro.localstorage.save('intro', '{introShown: true}', 1440 / 2)
        }
      }
    },
    localstorage: {
      save: (key, jsonData, expirationMin) => {
        if (!Modernizr.localstorage) {
          return false;
        }
        var expirationMS = expirationMin * 60 * 1000;
        var record = {
          value: JSON.stringify(jsonData),
          timestamp: new Date().getTime() + expirationMS
        }
        localStorage.setItem(key, JSON.stringify(record));
        return jsonData;
      },
      load: (key) => {
        if (!Modernizr.localstorage) {
          return false;
        }
        var record = JSON.parse(localStorage.getItem(key));
        if (!record) {
          return false;
        }
        return (new Date().getTime() < record.timestamp && JSON.parse(record.value));
      }
    }
  },
  hiddenNav: {
    distance: 0,
    active: false,
    init: () => {
      if (App.isMobile) return
      window.addEventListener('mousemove', throttle(App.hiddenNav.check, 128), false);
    },
    check: event => {
      App.hiddenNav.distance++
        if (!App.hiddenNav.active) {
          App.hiddenNav.distance = 0
          App.hiddenNav.show()
          window.clearTimeout(App.hiddenNav.tm)
          App.hiddenNav.tm = setTimeout(function() {
            App.hiddenNav.hide()
          }, 1500);
        } else
      if (App.hiddenNav.distance > 4) {
        App.hiddenNav.distance = 0
        App.hiddenNav.show()
      }
    },
    show: () => {
      App.hiddenNav.active = false
      document.querySelector('header').classList.remove('hidden')
    },
    hide: () => {
      App.hiddenNav.active = true
      document.querySelector('header').classList.add('hidden')
    }
  },
  interact: {
    init: () => {
      App.interact.embedKirby()
      App.interact.linkTargets()
      App.interact.eventTargets()
      App.interact.previews()
      Shop.init()
      Audio.init()
      Sliders.init()
      Players.init()
      Scroller.init()
      App.newsGrid.init()
      Pjax.init()
      imagesLoaded(document.getElementById('main'), Scroller.refresh)
    },
    previews: () => {
      const previews = document.querySelectorAll('.artist-preview')

      for (var i = 0; i < previews.length; i++) {
        previews[i].style.visibility = "hidden"
      }

      const artistsLinks = document.querySelectorAll('[data-page=artist][data-id]')

      for (var i = 0; i < artistsLinks.length; i++) {
        const elem = artistsLinks[i]
        const preview = document.querySelector('.artist-preview[data-id="' + elem.dataset.id + '"]')

        if (preview) {
          elem.addEventListener('mouseenter', e => {
            preview.style.visibility = 'visible'
          })
          elem.addEventListener('mouseleave', e => {
            preview.style.visibility = 'hidden'
          })
        }
      }
    },
    eventTargets: () => {
      const panelToggle = document.querySelectorAll('[event-target=panel]')

      for (var i = 0; i < panelToggle.length; i++) {
        panelToggle[i].addEventListener('click', e => {
          document.body.classList.toggle('infos-panel')
        })
      }

      const productToggle = document.querySelectorAll('[event-target=product-panel]')

      for (var i = 0; i < productToggle.length; i++) {
        const elem = productToggle[i]
        elem.addEventListener('click', e => {

          if (!document.body.classList.contains('about-panel')) {
            if (App.productOpened) {
              const opened = document.querySelector('.product.opened')
              if (opened) {
                opened.classList.remove('opened')
                App.productOpened = false
                document.body.classList.remove('product-opened')
                Scroller.enable('x')
              }
            } else {
              if (!elem.parentNode.classList.contains('opened')) {
                elem.parentNode.classList.add('opened')
                App.productOpened = true
                document.body.classList.add('product-opened')
                setTimeout(function() {
                  Scroller.shop.scrollToElement(elem.parentNode, 1000, (App.width - App.height) / -2, 0, IScroll.utils.ease.circular)
                }, 600);
                Scroller.disable('x')
              } else {
                elem.parentNode.classList.remove('opened')
                App.productOpened = false
                document.body.classList.remove('product-opened')
                Scroller.enable('x')
              }
            }
          }
        })
      }

      const aboutToggle = document.querySelectorAll('[event-target=about-panel]:not(.loaded)')

      for (var i = 0; i < aboutToggle.length; i++) {
        const elem = aboutToggle[i]
        elem.addEventListener('click', e => {
          e.preventDefault()
          elem.classList.add('loaded')
          document.body.classList.toggle('about-panel')
        })
      }

      const artistMedias = document.getElementById('artist-medias')

      if (artistMedias) {
        artistMedias.addEventListener('click', e => {

          let isPlayer = false

          Players.elements.forEach(elem => {
            if (elem.container.contains(e.target)) isPlayer = true
          })

          if (!isPlayer && !e.target.getAttribute('event-target') && e.target.tagName !== 'SPAN' && e.target.tagName !== 'DIV') document.body.classList.toggle('infos-panel')
        })
      }

    },
    linkTargets: () => {
      const links = document.querySelectorAll("a");
      for (var i = 0; i < links.length; i++) {
        const element = links[i];
        if (element.host !== window.location.host) {
          element.setAttribute('target', '_blank');
          element.setAttribute('rel', 'nofollow noopener');
        } else {
          element.setAttribute('target', '_self');
        }
      }
    },
    embedKirby: () => {
      var pluginEmbedLoadLazyVideo = function() {
        var wrapper = this.parentNode;
        var embed = wrapper.children[0];
        var script = wrapper.querySelector('script');
        embed.src = script ? script.getAttribute('data-src') + '&autoplay=1' : embed.getAttribute('data-src') + '&autoplay=1';
        wrapper.removeChild(this);
      };

      var thumb = document.getElementsByClassName('embed__thumb');

      for (var i = 0; i < thumb.length; i++) {
        thumb[i].addEventListener('click', pluginEmbedLoadLazyVideo, false);
      }
    },

  },
  newsGrid: {
    pattern: [
      [1, 1, 1, 1, 3, 3, 5, 5],
      [1, 1, 1, 1, 3, 3, 5, 5],
      [2, 2, 2, 2, 4, 4, 6, 6],
      [2, 2, 2, 2, 4, 4, 6, 6]
    ],
    init: () => {

      if (App.isMobile) return

      const news = document.getElementById('news')

      if (news && news.dataset.grid !== '[]') {
        App.newsGrid.pattern = JSON.parse(news.dataset.grid)
      }

      if (App.newsGrid.eg) {
        App.newsGrid.eg.destroy()
        App.newsGrid.eg = null
      }

      if (news) {
        App.newsGrid.eg = new InfiniteGrid("#news .grid", {
          margin: 10,
          horizontal: true,
        });

        App.newsGrid.eg.setLayout(FrameLayout, {
          margin: 10,
          frame: App.newsGrid.pattern
        });

        App.newsGrid.eg.on('layoutComplete', e => {
          Scroller.refresh()

          for (var i = 0; i < e.target.length; i++) {
            const elem = e.target[i].el
            if (elem.style.left == "0px") {
              elem.classList.add('side')
            } else {
              elem.classList.remove('side')
            }

            const caption = elem.querySelector('.caption')
            elem.style.paddingBottom = caption.offsetHeight + 'px'
          }
        })

        App.newsGrid.eg.layout()
      }
    },
    init2: () => {
      App.newsGrid.pckry = new Packery('#news .grid', {
        itemSelector: '.item',
        horizontal: true,
        gutter: 10,
        transitionDuration: 0
      });
      App.newsGrid.pckry.on('layoutComplete', function(laidOutItems) {
        for (var i = 0; i < laidOutItems.length; i++) {
          const elem = laidOutItems[i]
          console.log(elem.style.left, laidOutItems)
          // if (elem.style.left == 0) {
          //   elem.classList.add('side')
          // } else {
          //   elem.classList.remove('side')

          // }
        }
      })
    }
  }
}

const Sliders = {
  flickitys: [],
  init: () => {
    Sliders.elements = document.getElementsByClassName('slider');
    if (Sliders.elements.length > 0) {
      for (var i = 0; i < Sliders.elements.length; i++) {
        Sliders.flickity(Sliders.elements[i], {
          cellSelector: '.slide',
          imagesLoaded: true,
          lazyLoad: 1,
          cellAlign: 'left',
          setGallerySize: App.isMobile,
          adaptiveHeight: App.isMobile,
          wrapAround: true,
          prevNextButtons: true,
          pageDots: false,
          draggable: App.isMobile ? '>1' : false,
          arrowShape: 'M29.7 77.4l4.8-3.7L10 41.8h90v-6.1H10.1L34.5 4.6 29.7.9 0 38.7z'
        });
      }
      Sliders.accessibility()
    }
  },
  flickity: (element, options) => {
    Sliders.slider = new Flickity(element, options);
    Sliders.flickitys.push(Sliders.slider);
    if (Sliders.slider.slides.length < 1) return; // Stop if no slides

    Sliders.slider.on('change', function() {
      if (this.selectedElement) {
        const caption = this.element.parentNode.querySelector('.caption');
        if (caption)
          caption.innerHTML = this.selectedElement.getAttribute('data-caption');
        const number = this.element.parentNode.querySelector('.slide-number');
        if (number)
          number.innerHTML = (this.selectedIndex + 1) + '/' + this.slides.length;
      }
      const adjCellElems = this.getAdjacentCellElements(1);
      for (let i = 0; i < adjCellElems.length; i++) {
        const adjCellImgs = adjCellElems[i].querySelectorAll('.lazy:not(.lazyloaded):not(.lazyload)')
        for (let j = 0; j < adjCellImgs.length; j++) {
          adjCellImgs[j].classList.add('lazyload')
        }
      }
    });
    Sliders.slider.on('staticClick', function(event, pointer, cellElement, cellIndex) {
      if (!cellElement) {
        return;
      } else {
        this.next();
      }
    });
    if (Sliders.slider.selectedElement) {
      const caption = Sliders.slider.element.querySelector('.caption');
      if (caption)
        caption.innerHTML = Sliders.slider.selectedElement.getAttribute('data-caption');
      const number = Sliders.slider.element.parentNode.querySelector('.slide-number');
      if (number)
        number.innerHTML = (Sliders.slider.selectedIndex + 1) + '/' + Sliders.slider.slides.length;
    }
  },
  accessibility: () => {
    const prevNext = document.getElementsByClassName('flickity-prev-next-button')

    for (var i = 0; i < prevNext.length; i++) {
      const elem = prevNext[i]
      elem.addEventListener('mousemove', event => {
        var svg = elem.querySelector("svg");
        var parentOffset = elem.getBoundingClientRect();
        svg.style.top = event.pageY - parentOffset.top - pageYOffset + "px";
        svg.style.left = event.pageX - parentOffset.left + "px";

      })
    }

  }
}

const Shop = {
  scriptURL: 'https://sdks.shopifycdn.com/buy-button/latest/buy-button-storefront.min.js',
  init: () => {
    if (window.ShopifyBuy) {
      if (window.ShopifyBuy.UI) {
        Shop.ShopifyBuyInit();
      } else {
        loadScript();
      }
    } else {
      loadScript();
    }

    function loadScript() {
      var script = document.createElement('script');
      script.async = true;
      script.src = Shop.scriptURL;
      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(script);
      script.onload = Shop.ShopifyBuyInit;
    }
  },
  ShopifyBuyInit: () => {
    Shop.client = ShopifyBuy.buildClient({
      domain: 'bigwax.myshopify.com',
      apiKey: '31682f9bb9f4efdfdcfd96fb08af4c27',
      appId: '6',
    });

    const items = document.querySelectorAll('[data-shop]')

    items.forEach(el => {
      Shop.createButton(el.dataset.shop)
    })
  },
  createButton: id => {
    ShopifyBuy.UI.onReady(Shop.client).then(function(ui) {
      ui.createComponent('product', {
        id: [id],
        node: document.getElementById('product-component-' + id),
        moneyFormat: '%E2%82%AC%7B%7Bamount_with_comma_separator%7D%7D',
        options: {
          "product": {
            iframe: false,
            variantId: "all",
            events: {
              afterRender: Scroller.refresh
            },
            text: {
              button: "BUY"
            },
            "contents": {
              "img": false,
              "imgWithCarousel": false,
              "variantTitle": false,
              "description": false,
              "buttonWithQuantity": false,
              "quantity": false
            },
            "styles": {
              "product": {
                "@media (min-width: 601px)": {
                  "max-width": "calc(25% - 20px)",
                  "margin-left": "20px",
                  "margin-bottom": "50px"
                }
              },
              "button": {
                "color": "#fff",
                "background": "transparent",
                ":hover": {
                  "color": "#fff",
                  "background": "transparent",
                }
              },
              "price": {
                "color": "#fff",
                "fontSize": "15px",

              }
            }
          },
          "cart": {
            iframe: true,
            "contents": {
              "button": true
            },
            "styles": {
              "background-color": "#000",
              "color": "#fff",
              "footer": {
                "background-color": "#000",
                "color": "#fff"
              },
              "header": {
                "background-color": "#000",
                "color": "#fff"
              },
              "cartScroll": {
                "background-color": "#000",
                "color": "#fff"
              },
              "button": {
                "background-color": "#000",
                "color": "#fff",
                "border": "1px solid rgba(255,255,255,0.3)",
                ":hover": {
                  "background-color": "#000",
                  "color": "#fff",
                  "border": "1px solid rgba(255,255,255,0.3)",
                }
              }
            }
          },
          "lineItem": {
            "styles": {
              "quantity": {
                "filter": "invert(1)"
              }
            }
          },
          "toggle": {
            iframe: false,
            "contents": {
              "title": true,
              "icon": false
            },
            "text": {
              title: "Cart"
            },
            "styles": {
              "background-color": "#ffffff",
              "color": "#000000"

            }
          },
          "modalProduct": {
            "contents": {
              "img": false,
              "imgWithCarousel": true,
              "variantTitle": false,
              "buttonWithQuantity": true,
              "button": false,
              "quantity": false
            },
            "styles": {
              "product": {
                "@media (min-width: 601px)": {
                  "max-width": "100%",
                  "margin-left": "0px",
                  "margin-bottom": "0px"
                }
              }
            }
          },
          "productSet": {
            "styles": {
              "products": {
                "@media (min-width: 601px)": {
                  "margin-left": "-20px"
                }
              }
            }
          }
        }
      });
    });
  }
}

const Players = {
  elements: [],
  init: () => {
    const videoPlayers = document.getElementsByClassName('video-player')

    const options = {
      controls: [''],
      fullscreen: {
        enabled: true,
        fallback: true,
        iosNative: true
      },
      // iconUrl: _root + "/assets/images/player.svg"
    }


    for (var i = 0; i < videoPlayers.length; i++) {
      const videoElement = videoPlayers[i]
      const player = {
        element: videoElement,
        container: videoElement.parentNode
      }
      Players.elements.push(player)
    }

    Players.prepareStream(Players.elements)
    Players.events()
    Players.accessibility()

  },
  events: () => {

    for (var i = 0; i < Players.elements.length; i++) {
      const player = Players.elements[i]
      player.element.addEventListener('playing', e => {
        player.container.classList.add('video-is-playing')
      })
      player.element.addEventListener('pause', e => {
        player.container.classList.remove('video-is-playing')
      })
      player.element.addEventListener('click', e => {
        if (player.element.paused) {
          player.element.play()
        } else {
          player.element.pause()
        }
      })
    }

  },
  prepareStream: (players) => {

    if (players.length === 0) return;

    const attachStream = (player) => {
      if (player.element.dataset.stream && Hls.isSupported()) {
        player.hls = new Hls({
          minAutoBitrate: 1700000
        });
        player.hls.loadSource(player.element.dataset.stream);
        player.hls.attachMedia(player.element);
      }
    };

    for (var i = 0; i < players.length; i++) {
      attachStream(players[i]);
    }
  },
  pauseAll: () => {
    for (var i = 0; i < Players.elements.length; i++) {
      const player = Players.elements[i];
      player.element.pause()
    }
  },
  muteAll: () => {
    for (var i = 0; i < Players.elements.length; i++) {
      const player = Players.elements[i];
      player.container.classList.add('video-is-muted')
      player.element.muted = true
    }
  },
  unmute: player => {
    if (!Players.forceMute && player.muted) {
      Players.muteAll()
      player.container.classList.remove('video-is-muted')
      player.element.muted = false
    }
  },
  mute: player => {
    if (!player.muted) {
      player.container.classList.add('video-is-muted')
      player.element.muted = true
    }
  },
  accessibility: () => {
    for (var i = 0; i < Players.elements.length; i++) {
      const player = Players.elements[i];

      const playPause = player.container.querySelectorAll('[event-target=playpause]')
      const muteBtn = player.container.querySelector('[event-target=mute]')
      const unmuteBtn = player.container.querySelector('[event-target=unmute]')
      const fullscreenBtn = player.container.querySelector('[event-target=fullscreen]')
      const seekbar = player.container.querySelector('.seekbar')

      if (playPause) {
        for (var j = 0; j < playPause.length; j++) {
          playPause[j].addEventListener('click', () => {
            if (player.playing) {
              player.forceStop = true;
            } else {
              player.forceStop = false;
            }
            player.togglePlay()
          })
        }
      }
      if (muteBtn) {
        muteBtn.addEventListener('click', () => {
          Players.forceMute = true
          Players.mute(player)
        })
      }
      if (unmuteBtn) {
        unmuteBtn.addEventListener('click', () => {
          Players.forceMute = false
          Players.unmute(player)
        })
      }
      if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', () => {
          Players.forceMute = false
          player.fullscreen.enter()
          Players.unmute(player)
        })
      }
      const cursors = player.container.querySelectorAll('.video-cursor')


      player.container.addEventListener('mousemove', event => {
        for (var j = 0; j < cursors.length; j++) {
          const elem = cursors[j]
          const parentOffset = player.container.getBoundingClientRect();
          elem.style.top = event.pageY - parentOffset.top - pageYOffset + "px";
          elem.style.left = event.pageX - parentOffset.left + "px";
        }
      })
      if (seekbar) {
        player.element.addEventListener('timeupdate', () => {
          const percentage = (player.element.currentTime / player.element.duration) * 100;
          seekbar.querySelector('.thumb').style.left = percentage + '%'
        });

        seekbar.addEventListener('mouseenter', () => {
          cursors.forEach(el => {
            el.style.display = 'none'
          })
        })

        seekbar.addEventListener('mouseleave', () => {
          cursors.forEach(el => {
            el.removeAttribute('style')
          })
        })

        seekbar.addEventListener('click', e => {
          let offset = seekbar.getBoundingClientRect()
          let left = (e.pageX - offset.left)
          let totalWidth = seekbar.offsetWidth
          let percentage = (left / totalWidth)
          let vidTime = player.element.duration * percentage
          player.element.currentTime = vidTime
        });
      }
    }
  }
}

const Scroller = {
  elements: [],
  optionsX: {
    scrollX: true,
    scrollY: false,
    freeScroll: true,
    mouseWheel: true,
    scrollbars: false,
    tap: 'tapEvent',
    interactiveScrollbars: false,
    preventDefault: true,
    preventDefaultException: {
      tagName: /^(INPUT|TEXTAREA|BUTTON|SELECT|A)$/
    },
    bounce: false
  },
  optionsY: {
    mouseWheel: true,
    freeScroll: true,
    scrollbars: true,
    fadeScrollbars: true,
    tap: 'tapEvent',
    interactiveScrollbars: true,
    preventDefault: true,
    preventDefaultException: {
      tagName: /^(INPUT|TEXTAREA|BUTTON|SELECT|A)$/
    },
    bounce: false
  },
  init: function() {
    Scroller.elements = []
    if (!App.isMobile) {
      document.querySelectorAll('[data-scroll=y]').forEach(scroller => {
        const s = new IScroll(scroller, Scroller.optionsY)
        s.direction = "y"
        Scroller.elements.push(s)
      })

      document.querySelectorAll('[data-scroll=x]').forEach(scroller => {
        const s = new IScroll(scroller, Scroller.optionsX)
        s.direction = "x"
        Scroller.elements.push(s)
      })
    } else {
      document.querySelectorAll('[data-scrollmobile=y]').forEach(scroller => {
        const s = new IScroll(scroller, Scroller.optionsY)
        s.direction = "y"
        Scroller.elements.push(s)
      })

      document.querySelectorAll('[data-scrollmobile=x]').forEach(scroller => {
        const s = new IScroll(scroller, Scroller.optionsX)
        s.direction = "x"
        Scroller.elements.push(s)
      })
    }

    Scroller.shop = null

    Scroller.elements.forEach(s => {
      if (s.wrapper.id === 'shop') {
        Scroller.shop = s
      }
    })

    if (Scroller.shop) {
      const hash = getUrlParams()
      if (hash.product) {
        const elem = document.querySelector('[data-id="' + hash.product + '"] [event-target]')
        if(elem) simulateClick(elem)
      }
    }
    // document.addEventListener('lazybeforeunveil', Scroller.refresh);
  },
  enable: function(direction) {
    if (direction) {
      for (var i = 0; i < Scroller.elements.length; i++) {
        if (Scroller.elements[i].direction === direction) Scroller.elements[i].enable();
      }
    } else {
      for (var i = 0; i < Scroller.elements.length; i++) {
        Scroller.elements[i].enable();
      }
    }
  },
  disable: function(direction) {
    if (direction) {
      for (var i = 0; i < Scroller.elements.length; i++) {
        if (Scroller.elements[i].direction === direction) Scroller.elements[i].disable();
      }
    } else {
      for (var i = 0; i < Scroller.elements.length; i++) {
        Scroller.elements[i].disable();
      }
    }
  },
  refresh: function() {
    for (var i = 0; i < Scroller.elements.length; i++) {
      const elem = Scroller.elements[i]
      setTimeout(function() {
        elem.refresh();
      }, 0);
    }
  }
}

const Audio = {
  init: () => {
    Audio.songs = null
    Audio.player = document.getElementById('player')

    if (Audio.player) Audio.songs = JSON.parse(Audio.player.dataset.songs)

    if (Audio.player && Audio.songs) {
      Amplitude.init({
        "bindings": {
          37: 'prev',
          39: 'next',
          32: 'play_pause'
        },
        "songs": Audio.songs,
        "continue_next": false,
        "callbacks": {
          'after_play': function() {
            window.clearTimeout(Audio.stopTm)
            document.body.classList.add('player-playing')
          },
          'after_stop': function() {
            window.clearTimeout(Audio.stopTm)
            if (App.isMobile) {
              Audio.stopTm = setTimeout(function() {
                document.body.classList.remove('player-playing')
              }, 300);
            } else {
              document.body.classList.remove('player-playing')
            }
          }
        }
      });
      // var p = document.getElementById("player");
      // var d = document.getElementById("duration");
      // document.getElementById('progress-container').addEventListener('click', function(e) {
      //   var offset = this.getBoundingClientRect();
      //   var x = e.pageX - offset.left;

      //   Amplitude.setSongPlayedPercentage((parseFloat(x) / parseFloat(this.offsetWidth)) * 100);
      // });
    }
  }
}

const Pjax = {
  titleTransition: 0.7,
  init: function() {
    Barba.Pjax.getTransition = function() {
      return Pjax.hideShowTransition
    };
    Barba.Dispatcher.on('linkClicked', function(el) {
      App.linkClicked = el
    });
    Barba.Dispatcher.on('newPageReady', function(currentStatus, oldStatus, container) {
      var js = container.querySelector("script");
      if (js != null) {
        eval(js.innerHTML);
        Audio.init()
      }
    });
    Barba.Pjax.Dom.wrapperId = 'main'
    Barba.Pjax.Dom.containerClass = 'pjax'
    Barba.BaseCache.reset()
    // Barba.Pjax.cacheEnabled = false;
    Barba.Pjax.start()
  },
  hideShowTransition: Barba.BaseTransition.extend({
    start: function() {
      let _this = this
      _this.newContainerLoading.then(_this.startTransition.bind(_this))
    },
    startTransition: function() {
      document.body.classList.add('is-loading')
      document.body.classList.remove('player-playing', 'infos-panel', 'about-panel', 'product-opened')
      Amplitude.pause()

      let _this = this
      const newContent = _this.newContainer.querySelector('#page-content')

      // const currentLink = document.querySelector('a.active')
      // if (currentLink) currentLink.classList.remove('active')
      // if (App.linkClicked) App.linkClicked.classList.add('active')

      App.nextPageType = newContent.getAttribute('page-type')

      if (App.pageType == 'ok') {

      } else {
        document.body.setAttribute('page-type', App.nextPageType)
        _this.endTransition(_this, newContent)
      }

    },
    endTransition: function(_this, newContent) {
      window.scroll(0, 0)
      resizeWindow()

      if (App.nextPageType == 'ok') {

      } else {
        _this.finish(_this, newContent)
      }
    },
    finish: function(_this, newContent) {

      _this.done()
      App.pageType = App.nextPageType

      App.sizeSet()
      App.interact.init()
      document.body.classList.remove('is-loading')

      // setTimeout(function() {
      //   TweenMax.set(document.querySelector('#page-content'), {
      //     clearProps: 'transform,opacity'
      //   })
      // }, 500);

      if (window.ga) window.ga('send', 'pageview')
    }


  })
}

document.addEventListener("DOMContentLoaded", App.init);
