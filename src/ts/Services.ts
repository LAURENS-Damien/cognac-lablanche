import axios from 'axios';
import * as Constants from '@/ts/constants';

export default class Services {
    public static test(): string {
        return 'Coucou';
    }
    public static getWPDatasOld() {
        axios.get(Constants.URL_PAGES)
          .then((response) => {
              return response.data;
          })
          .catch((error) => {
              // handle error
              window.location.href = '/error';
          });
    }
    public static async getWPDData() {
      axios.get(Constants.URL_PAGES)
        .then((response) => {
          this.reponse = response.data;
          return response.data;
        })
        .catch((error) => {
          window.location.href = '/error';
        });
    }
  private static reponse: any;
}
