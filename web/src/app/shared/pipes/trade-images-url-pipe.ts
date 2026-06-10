import { Pipe, PipeTransform } from '@angular/core';
import { environment } from '../../../environments/environment';

@Pipe({
  name: 'tradeImagesUrl',
  standalone: true
})
export class TradeImagesUrlPipe implements PipeTransform {
  transform(path: string | null): string {

    if (!path) {
      return 'assets/photoicon.png';
    }

    return `${environment.storageUrl}/${path}`;
  }
}
