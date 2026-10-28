import {
  AppWindow, Bed, Briefcase, ChartLine, Code, GraduationCap, Handshake, Headset, Megaphone, Scale, Stethoscope, Truck, Users,
  type LucideProps,
} from "lucide-react";

const ICONS = {
  briefcase: Briefcase, "app-window": AppWindow, headset: Headset, "graduation-cap": GraduationCap, "chart-line": ChartLine,
  scale: Scale, truck: Truck, megaphone: Megaphone, handshake: Handshake, users: Users, stethoscope: Stethoscope, bed: Bed, code: Code,
} as const;

export function CategoryIcon({ name, ...p }: { name: string } & LucideProps) {
  const Icon = ICONS[name as keyof typeof ICONS] ?? AppWindow;
  return <Icon {...p} />;
}
