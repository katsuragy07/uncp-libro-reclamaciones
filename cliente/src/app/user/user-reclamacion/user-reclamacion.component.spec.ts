import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UserReclamacionComponent } from './user-reclamacion.component';

describe('UserReclamacionComponent', () => {
  let component: UserReclamacionComponent;
  let fixture: ComponentFixture<UserReclamacionComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ UserReclamacionComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(UserReclamacionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
