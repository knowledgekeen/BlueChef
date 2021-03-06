import { GlobalService } from './global.service';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class MenuService {
  server: any;
  mtype: any;
  constructor(private _http: HttpClient, private _global: GlobalService) {
    this.server = _global.serverpath;
  }

  getAllMenus(){
    return this._http.get(this.server + 'assets/db/menu.php?action=allMenus');
  }

  
  getHotelMenus(hid){
    return this._http.get(this.server + 'assets/db/menu.php?action=hotelMenus&hotelId='+ hid);
  }

  getMtype(){
    return this._http.get(this.server + 'assets/db/menu.php?action=menuType');
  }
  getMenuList(){
    return this._http.get(this.server + 'assets/db/menu.php?action=menuList');
  }

  addMenu(mname, mtype, userid) {
   
    this.mtype = mtype.split('.')[0];
    let menuObj = {
      'mname': mname,
      'mtypeid': this.mtype,
      'userid': userid
    }
    return this._http.post(this.server + "assets/db/menu.php?action=addMenu", menuObj);
  }
  toggleMenu(mid, action, userid) {
    
    let toggleObj = {
      'mid': mid,
      'action': action,
      'userid': userid
    }
    return this._http.post(this.server + "assets/db/menu.php?action=toggleMenu", toggleObj);
  }
   
}

