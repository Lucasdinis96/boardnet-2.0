import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { SandboxComponent } from './features/sandbox/sandbox.component';
import { AuthService } from './core/services/auth.service';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, SandboxComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  protected readonly title = signal('web');

  constructor (private authService: AuthService){}

  ngOnInit() {
    if(this.authService.isAuthenticated()) {
      this.authService.fetchUser();
    }
  }

}
