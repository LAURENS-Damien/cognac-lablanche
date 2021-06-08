export class WpDatas {
  public homePageDatas?: HomePageDatas;
  public productionDatas?: ProductionDatas;
  public vineyardManagementDatas?: VineyardManagementDatas;
  public historicDatas?: HistoricDatas;
  public campingCarParkingDatas?: CampingCarParkingDatas;
  public galleryDatas?: GalleryDatas;
  public contactDatas?: ContactDatas;
  public orderDatas?: OrderDatas;
  public shopPresentationDatas?: ShopPresentationDatas;

  constructor(homePageDatas?: HomePageDatas,
              productionDatas?: ProductionDatas,
              vineyardManagement?: VineyardManagementDatas,
              historicDatas?: HistoricDatas,
              campingCarParkingDatas?: CampingCarParkingDatas,
              galleryDatas?: GalleryDatas,
              contactDatas?: ContactDatas,
              orderDatas?: OrderDatas,
              shopPresentationDatas ?: ShopPresentationDatas) {
    this.homePageDatas = homePageDatas;
    this.productionDatas = productionDatas;
    this.vineyardManagementDatas = vineyardManagement;
    this.historicDatas = historicDatas;
    this.campingCarParkingDatas = campingCarParkingDatas;
    this.galleryDatas = galleryDatas;
    this.contactDatas = contactDatas;
    this.orderDatas = orderDatas;
    this.shopPresentationDatas = shopPresentationDatas;
  }
}

export interface HomePageDatas {
  readonly id: string;
  readonly title: string;
  readonly content: string;
  readonly image: string;
}

export interface ProductionDatas extends Array<Category> {}

export interface Category {
  readonly categoryTitle: string;
  readonly categoryName: string;
  selected: boolean;
}

export interface VineyardManagementDatas {
  readonly title: string;
  readonly zigag: string[];
}

export interface HistoricDatas {
  readonly title: string;
  readonly content: string;
  readonly image: string;
}

export interface CampingCarParkingDatas {
  readonly title: string;
  readonly content: string;
  readonly image: string;
}

export interface GalleryDatas {
  readonly title: string;
  readonly content: string;
}

export interface ContactDatas {
  readonly title: string;
  readonly content: string;
}

export interface OrderDatas {
  readonly title: string;
  readonly content: string;
}

export interface ShopPresentationDatas {
  readonly title: string;
  readonly content: string;
  readonly image: string;
}
