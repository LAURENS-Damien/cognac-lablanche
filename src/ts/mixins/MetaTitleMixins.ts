import {Vue, Component} from 'vue-property-decorator';

@Component
export default class MetaTitleMixins extends Vue {
  public created() {
    const metaTitle = this.getMetaTitle(this);
    if (metaTitle) {
      document.title = metaTitle;
    }
  }

  public getMetaTitle(vm: any) {
    const {metaTitle} = vm;
    if (metaTitle) {
      return typeof metaTitle === 'function'
        ? metaTitle.call(vm)
        : metaTitle;
    }
  }
}
