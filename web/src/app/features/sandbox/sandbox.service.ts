import { Injectable } from '@angular/core';
import { ApiService } from '../../core/services/api.service';

@Injectable({
  providedIn: 'root',
})
export class SandboxService {

  constructor (private api: ApiService){}

  getTeste(){
    return this.api.get<any[]>('boardgames');
  }

  getTeste2(){
    return this.api.get<any[]>('trades');
  }

  getTesteShow() {
    return this.api.show<any>('boardgames', '3');
  }

  postTeste(credentials: any) {
    return this.api.post('auth/login', credentials);
  }

  putTeste(credentials: any){
    return this.api.put('profile/update', '1', credentials);
  }

  deleteTeste(){
    return this.api.delete('profile/my-trades/delete', '1');
  }

}
