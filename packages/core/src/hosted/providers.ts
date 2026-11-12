import * as cw from "./chatwoot";
import * as doc from "./documenso";
import { easyAppointments } from "./easyappointments";
import * as inv from "./invoiceshelf";
import { openWebUi } from "./openwebui";
import * as plane from "./plane";
import * as twenty from "./twenty";
import type { HostedProvider } from "./types";

export type ProviderName = "twenty" | "invoiceshelf" | "chatwoot" | "plane" | "documenso" | "easyappointments" | "openwebui";

export const PROVIDERS: Record<ProviderName, HostedProvider> = {
  twenty: {
    configured: () => twenty.twentyConfig() !== null,
    accountScope: "provider",
    createTenant: (ws) => twenty.createTwentyWorkspace(ws.slug, ws.name),
    deleteTenant: (t) => twenty.deleteTwentyWorkspace(t),
    addMember: (t, login, password, name, role) => twenty.addTwentyMember(t, login, password, name, role),
    setRole: (t, id, role) => twenty.setTwentyRole(t, id, role),
    removeMember: (t, id) => twenty.removeTwentyMember(t, id),
    signIn: async (t, login, password) => ({ kind: "url", url: await twenty.twentyLoginUrl(t, login, password) }),
    reconcile: (t, keep) => twenty.reconcileTwentyMembers(t, keep),
  },
  invoiceshelf: {
    configured: () => inv.invoiceShelfConfig() !== null,
    accountScope: "tenant",
    createTenant: (ws) => inv.createInvoiceShelfCompany(ws.name, ws.slug, ws.currency),
    deleteTenant: (t) => inv.deleteInvoiceShelfCompany(t),
    addMember: inv.addInvoiceShelfMember,
    setRole: inv.setInvoiceShelfRole,
    removeMember: inv.removeInvoiceShelfMember,
    signIn: inv.invoiceShelfSignIn,
  },
  chatwoot: {
    configured: () => cw.chatwootConfig() !== null,
    accountScope: "tenant",
    createTenant: (ws) => cw.createChatwootAccount(ws.name),
    deleteTenant: cw.deleteChatwootAccount,
    addMember: cw.addChatwootMember,
    setRole: cw.setChatwootRole,
    removeMember: cw.removeChatwootMember,
    signIn: (t, _login, _password, memberId) => cw.chatwootSignIn(t, memberId),
  },
  plane: {
    configured: () => plane.planeConfig() !== null,
    accountScope: "tenant",
    createTenant: (ws) => plane.createPlaneWorkspace(ws.slug, ws.name),
    deleteTenant: plane.deletePlaneWorkspace,
    addMember: plane.addPlaneMember,
    setRole: plane.setPlaneRole,
    removeMember: async (t, id, account) => {
      if (!account) throw new Error("Plane removal needs the member's sign-in");
      await plane.removePlaneMember(t, id, account.login, account.password);
    },
    signIn: plane.planeSignIn,
  },
  documenso: {
    configured: () => doc.documensoConfig() !== null,
    accountScope: "tenant",
    createTenant: (ws) => doc.createDocumensoOrganisation(ws.slug, ws.name),
    deleteTenant: doc.deleteDocumensoOrganisation,
    addMember: doc.addDocumensoMember,
    setRole: doc.setDocumensoRole,
    removeMember: (t, id) => doc.removeDocumensoMember(t, id),
    signIn: doc.documensoSignIn,
  },
  easyappointments: easyAppointments,
  openwebui: openWebUi,
};
