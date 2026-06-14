import { Component, inject, OnInit } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { UserService } from '../../../../services/user.service';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-user-pix',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-pix.component.html',
  styleUrl: './user-pix.component.scss'
})

export class UserPixComponent {
  private userService = inject(UserService)
  private flashMessage = inject(FlashMessageService)
  private fb = inject(FormBuilder)
  loading = false;
  saving = false;


  form = this.fb.group({
    pix_key: [''],
    pix_key_type: ['']
  });

  ngOnInit(): void {
    this.loadPixData();
  }

  loadPixData(): void {
    this.loading = true;

    this.userService.getPixData().subscribe({
      next: (data) => {
        this.form.patchValue(data);
        this.loading = false;
      },
      error: () => {
        this.loading = false;

        this.flashMessage.error(
          'Erro ao carregar dados PIX.'
        );
      }
    });
  }

  save(): void {

    if (this.form.invalid) {
      this.form.markAllAsTouched();
      return;
    }

    this.saving = true;

    this.userService.updatePixData(
      this.form.getRawValue()
    ).subscribe({
      next: (response: any) => {

        this.saving = false;

        this.flashMessage.success(
          response.message ?? 'Dados PIX atualizados.'
        );
      },
      error: (response) => {

        this.saving = false;

        this.flashMessage.error(
          response.error?.message ??
          'Erro ao atualizar dados PIX.'
        );
      }
    });
  }
}