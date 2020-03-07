export enum ViewState {
  Loading = 1,
  Loaded = 2,
  Error = 3,
}

export interface HomePageDatas {
  id: string;
  title: string;
  content: string;
  image: string;
}

export interface AppState {
  wpDatas: WpDatas;
}

export class WpDatas {
  public homePageDatas?: HomePageDatas;

  constructor(homePageDatas?: HomePageDatas) {
    this.homePageDatas = homePageDatas;
  }
}
