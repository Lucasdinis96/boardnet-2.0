import { Pipe, PipeTransform } from '@angular/core';
import { environment } from '../../../environments/environment';

@Pipe({
  name: 'avatarUrl',
  standalone: true
})
export class AvatarUrlPipe implements PipeTransform {
  transform(path?: string | null): string {

    if (!path) {
      return 'assets/avatar.png';
    }

    return `${environment.apiUrl}/storage/${path}`;
  }
}
