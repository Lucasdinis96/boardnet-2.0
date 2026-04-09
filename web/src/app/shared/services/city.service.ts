import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../core/services/api.service';

@Injectable({
  providedIn: 'root',
})
export class CityService {
  private api = inject(ApiService);

  searchCities(term: string) {
    return this.api.get<any[]>(`cities/search?name=${term}`);
  }
}
