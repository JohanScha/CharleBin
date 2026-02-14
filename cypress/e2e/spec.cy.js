describe("CharleBin", () => {
  it("créé paste mdp, charge URL, saisit mdp, vérifie message", () => {
    const message = "Test Cypress " + Date.now();
    const mdp = "1234";

    cy.visit("http://localhost:8080");
    cy.contains("Nouveau").click();
    cy.get("textarea").first().type(message);
    cy.get("input[placeholder*='recommand' i]").type(mdp);
    cy.contains("Envoyer").click();

    cy.location("href").then((url) => {
      cy.visit(url);
      cy.get('input[placeholder*="Entrez le mot de passe"]').first().type(mdp, {force: true});  // Saisit MDP
      cy.contains("Déchiffrer").click({ force: true });
      cy.contains(message).should("be.visible");  // Vérifie après saisie
    });
  });
});
