Feature: checking the GET /api/users endpoint

    Scenario: I cannot list users if I'm an anonymous user
        When I request the "/users" endpoint
        Then the response should be a 401 error response with message:
            """
            Authentication required.
            """

    @user("John Doe")
    Scenario: I can list users if I'm a regular user
        When I request the "/users" endpoint
        Then the response should be successful
        And the response should have 3 items
        And the response should match:
            """
            [
                {
                    "id": @integer@,
                    "token": "t3nt4c0d3",
                    "name": "Tentacode",
                    "email": "tentacode@example.com",
                    "role": "ROLE_ADMIN"
                },
                @...@
            ]
            """
