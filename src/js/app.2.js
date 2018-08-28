import Links from './components/links';
import Embeds from './components/embeds';

const App = {
  init: async () => {
    await Loader.init();
    await Links.init();
    await Embeds.init();
    Loader.loaded();
  }
};

export default App;
