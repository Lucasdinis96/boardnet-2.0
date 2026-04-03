import { Component, inject, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { SandboxComponent } from './features/sandbox/sandbox.component';
import { AuthService } from './core/services/auth.service';
import { HeaderComponent } from './shared/header/header.component';
import { FooterComponent } from './shared/footer/footer.component';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, SandboxComponent, HeaderComponent, FooterComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  protected readonly title = signal('web');

  private authService = inject(AuthService);

  ngOnInit() {
    this.authService.initSession();
  }

}
