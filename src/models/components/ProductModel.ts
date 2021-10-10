export interface ProductModel {
  readonly id: number;
}

// TODO : Supprimer cette interface car il faudrait pouvoir directement caster le retour d'axios
//  en ProductCustomFieldsModel
export interface ProductAcfsModel {
  readonly acf: object;
}

export interface ProductCustomFieldsModel {
  readonly appellation: string;
  readonly description: string;
  readonly cepage: string;
  readonly temperature_ideale_de_service: string;
  readonly nez: string;
  readonly bouche: string;
  readonly suggestions: string;
  readonly divers: string;
  readonly prix: string;
}
