import { createAccessControl } from "better-auth/plugins/access";
import { adminAc, defaultStatements, memberAc, ownerAc } from "better-auth/plugins/organization/access";

// Shared by server and client so both agree on the role set (owner | admin | member | guest).
// App-level permissions (records, apps) are enforced in @mewe/core.
export const ac = createAccessControl(defaultStatements);

export const roles = {
  owner: ac.newRole(ownerAc.statements),
  admin: ac.newRole(adminAc.statements),
  member: ac.newRole(memberAc.statements),
  guest: ac.newRole({}),
};
