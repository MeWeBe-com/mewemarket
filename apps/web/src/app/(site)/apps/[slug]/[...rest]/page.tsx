import { legacyAppDirSlug } from "@mewe/core";
import { notFound, permanentRedirect } from "next/navigation";

// Old hosted demo URLs such as /apps/kanboard/Demo or /apps/companyexpense/index.php/login.
export default async function LegacyAppPath({ params }: { params: Promise<{ slug: string }> }) {
  const slug = decodeURIComponent((await params).slug);
  const moved = legacyAppDirSlug(slug);
  if (moved) permanentRedirect(`/apps/${moved}`);
  notFound();
}
