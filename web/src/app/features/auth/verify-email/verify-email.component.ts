import { Component, inject } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { RegisterService } from '../register/register.service';

@Component({
  selector: 'app-verify-email',
  imports: [],
  templateUrl: './verify-email.component.html',
  styleUrl: './verify-email.component.scss',
})
export class VerifyEmailComponent {

  private route = inject(ActivatedRoute);
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
      next: () => console.log('Email verificado com sucesso'),
      error: () => console.log('Token inválido ou expirado')
    })
  }
}
