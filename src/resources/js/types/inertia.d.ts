import { PageProps as InertiaPageProps } from '@inertiajs/inertia';
import { Address } from '@/types/address'; 

export interface PageProps extends InertiaPageProps {
  address?: Address;
}
