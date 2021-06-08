import {WpDatas} from '@/ts/WpDatas';

export enum ViewState {
  Loading = 1,
  Loaded = 2,
  Error = 3,
}

export interface AppState {
  wpDatas: WpDatas;
}
