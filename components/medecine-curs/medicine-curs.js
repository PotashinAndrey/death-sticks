import Component from '/material/script/Component.js';

import MaterialList     from '/material/components/list/material-list.js';
import MaterialExpand from '/material/components/expand/material-expand.js';

const component = Component.meta(import.meta.url, 'medicine-curs');
/**
  *
  */
  export default class MedicineCurs extends Component {
  /**
    *
    */
    constructor() {
      super(component);
    }

  /** */
    mount(content) {
      
    }
  }

Component.define(component, MedicineCurs);