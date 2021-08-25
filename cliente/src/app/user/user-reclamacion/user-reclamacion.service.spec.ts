import { TestBed } from '@angular/core/testing';

import { UserReclamacionService } from './user-reclamacion.service';

describe('UserReclamacionService', () => {
  let service: UserReclamacionService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(UserReclamacionService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
