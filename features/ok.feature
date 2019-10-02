Feature: checking the /api/ok endpoint

    Scenario: The ok api should return ok
        When I request the "/ok" endpoint
        Then the response should be successful
        And the response should match:
          """
          {"ok": true}
          """