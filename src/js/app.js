/* jshint esversion: 6 */

// import 'babel-polyfill'
import lazysizes from 'lazysizes'
import optimumx from 'lazysizes'
require('../../node_modules/lazysizes/plugins/object-fit/ls.object-fit.js')
require('../../node_modules/lazysizes/plugins/unveilhooks/ls.unveilhooks.js')
import Amplitude from 'amplitudejs'
import imagesLoaded from 'imagesloaded'
import Flickity from 'flickity'
import IScroll from 'iscroll'
import Hls from 'hls.js'
import throttle from 'lodash.throttle'
import {
  TweenMax,
  AttrPlugin
} from 'gsap'
import Barba from 'barba.js'


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
    App.interact.init()
    window.addEventListener('resize', throttle(App.sizeSet, 128), false);
    document.getElementById('loader').style.display = 'none'

    // document.addEventListener('lazybeforeunveil', Scroller.refresh);
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
    App.sizeElements();
  },
  sizeElements: () => {

    App.header = document.querySelector('header')
    App.menu = document.getElementById('menu')

    sizeElem('project-medias', null, App.height - (App.header.offsetHeight + App.menu.offsetHeight))
    placeElem('project-medias', (App.header.offsetHeight + App.menu.offsetHeight), null)

    if (App.isMobile && App.pageType !== 'about') margeElem('page-content', (App.header.offsetHeight + App.menu.offsetHeight))

  },
  interact: {
    init: () => {
      App.interact.embedKirby()
      App.interact.linkTargets()
      App.interact.eventTargets()
      App.interact.previews()
      Audio.init()
      Sliders.init()
      Players.init()
      Scroller.init()
      Pjax.init()
      imagesLoaded(document.getElementById('main'), Scroller.refresh)
    },
    previews: () => {
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
          elem.parentNode.classList.toggle('opened')
        })
      }

      const artistMedias = document.getElementById('artist-medias')

      if(artistMedias) artistMedias.addEventListener('click', e => {

          if(!e.target.getAttribute('event-target') && e.target.tagName !== 'SPAN' && e.target.tagName !== 'DIV') document.body.classList.remove('infos-panel')
        })

    },
    linkTargets: () => {
      const links = document.querySelectorAll("a");
      for (var i = 0; i < links.length; i++) {
        const element = links[i];
        if (element.host !== window.location.host) {
          element.setAttribute('target', '_blank');
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
      player.container.addEventListener('click', e => {
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

      const cursors = player.container.getElementsByClassName('video-cursor')


      player.container.addEventListener('mousemove', event => {
        for (var j = 0; j < cursors.length; j++) {
          const elem = cursors[j]
          const parentOffset = player.container.getBoundingClientRect();
          elem.style.top = event.pageY - parentOffset.top - pageYOffset + "px";
          elem.style.left = event.pageX - parentOffset.left + "px";
        }

      })
    }
  }
}

const Scroller = {
  elements: [],
  init: function() {
    Scroller.elements = []
    if (App.isMobile) return
    const vscrollers = document.querySelectorAll('[data-scroll=y]')
    for (var i = 0; i < vscrollers.length; i++) {
      const s = new IScroll(vscrollers[i], {
        mouseWheel: true,
        freeScroll: true,
        scrollbars: false,
        interactiveScrollbars: false,
        preventDefault: true,
        bounce: false
      })
      Scroller.elements.push(s)
    }
    const xscrollers = document.querySelectorAll('[data-scroll=x]')
    for (var i = 0; i < xscrollers.length; i++) {
      const s = new IScroll(xscrollers[i], {
        scrollX: true,
        scrollY: false,
        freeScroll: true,
        mouseWheel: true,
        scrollbars: false,
        interactiveScrollbars: false,
        preventDefault: true,
        bounce: false
      })
      Scroller.elements.push(s)
    }
    document.addEventListener('lazybeforeunveil', Scroller.refresh);
  },
  enable: function() {
    for (var i = 0; i < Scroller.elements.length; i++) {
      Scroller.elements[i].enable();
    }
  },
  disable: function() {
    for (var i = 0; i < Scroller.elements.length; i++) {
      Scroller.elements[i].disable();
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
    if (document.getElementById('player') && typeof songs != "undefined") {
      Amplitude.init({
        "bindings": {
          37: 'prev',
          39: 'next',
          32: 'play_pause'
        },
        "songs": songs,
        "continue_next": false,
        "callbacks": {
          'after_play': function() {
            window.clearTimeout(Audio.stopTm)
            document.body.classList.add('player-playing')
          },
          'after_stop': function() {
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
      document.body.classList.remove('player-playing')
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
