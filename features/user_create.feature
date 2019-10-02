Feature: checking the POST /api/users endpoint

    Scenario: I cannot create a user if I'm not authenticated
        When I make a POST request to the "/users" endpoint with body:
            """
            {}
            """
        Then the response should be a 401 error response with message:
            """
            Authentication required.
            """

    @user("John Doe")
    Scenario: I cannot create a user if I'm a regular user
        When I make a POST request to the "/users" endpoint with body:
            """
            {}
            """
        Then the response should be a 403 error response

    @user("Tentacode")
    Scenario: I can create a user if I'm an admin
        When I make a POST request to the "/users" endpoint with body:
            """
            {
                "name": "Carmen Sandiego",
                "token": "krmen",
                "email": "c.sandiego@example.com"
            }
            """
        Then the response should be a 201 successful response

        # Checking that the user is added to the user list
        When I request the "/users" endpoint
        Then the response should be successful
        And the response should have 4 items
        And the response should match:
            """
            [
                @...@,
                {
                    "id": @integer@,
                    "name": "Carmen Sandiego",
                    "token": "krmen",
                    "email": "c.sandiego@example.com",
                    "name": "Carmen Sandiego",
                    "role": "ROLE_USER"
                }
            ]
            """