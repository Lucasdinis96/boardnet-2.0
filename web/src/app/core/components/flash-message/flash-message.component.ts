import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FlashMessageService } from '../../services/flash-message.service';

@Component({
  selector: 'app-flash-message',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './flash-message.component.html',
  styleUrls: ['./flash-message.component.scss']
})
export class FlashMessageComponent {

  message$;

  constructor(
    private flashMessageService: FlashMessageService
  ) {
    this.message$ = this.flashMessageService.message$;
  }

}