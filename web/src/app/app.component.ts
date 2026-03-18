import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { SandboxComponent } from './features/sandbox/sandbox.component';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, SandboxComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  protected readonly title = signal('web');
}
