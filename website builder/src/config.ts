let BACKEND_URL = "http://127.0.0.1:5000/";
let UI_KIT = "";

export const Config = {
  get backendUrl() {
    return "http://127.0.0.1:5000/";
  },
  set backendUrl(url: string) {
    console.log(`Set backendUrl to ${url}`);
    BACKEND_URL = url;
  },
  get uiKit() {
    return UI_KIT;
  },
  set uiKit(kit: string) {
    console.log(`Set uiKit to ${kit}`);
    UI_KIT = kit;
  },
};
