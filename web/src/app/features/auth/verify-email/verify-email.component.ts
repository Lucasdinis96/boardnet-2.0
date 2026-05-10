import { Component, inject } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { RegisterService } from '../register/register.service';
import { debounceTime } from 'rxjs';

@Component({
  selector: 'app-verify-email',
  imports: [RouterLink],
  templateUrl: './verify-email.component.html',
  styleUrl: './verify-email.component.scss',
})
export class VerifyEmailComponent {

  private route = inject(ActivatedRoute);
  private router = inject(Router);
  private registerService = inject(RegisterService);

  token!: string;

  ngOnInit() {
    const token = this.route.snapshot.paramMap.get('token');

    if (token) {
      this.verifyEmail(token);
    }
  }

  verifyEmail(token: string){
    this.registerService.verifyEmail(token).subscribe({
      next: () => {
        console.log('Email verificado com sucesso');
        debounceTime(3000);
        this.router.navigate(['/home'], { replaceUrl: true });
      },
      error: () => console.log('Token inválido ou expirado')
    })
  }
}
