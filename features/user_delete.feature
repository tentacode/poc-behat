Feature: checking the DELETE /api/users/{userId} endpoint

    Scenario: I cannot delete a user if I'm an anonymous user
        When I delete the "John Doe" user
        Then the response should be a 401 error response with message:
            """
            Authentication required.
            """

    @user("John Doe")
    Scenario: I cannot delete a user if I'm a regular user
        When I delete the "John Doe" user
        Then the response should be a 403 error response with message:
            """
            Access Denied.
            """

    @user("Tentacode")
    Scenario: I can delete a user if I'm an admin
        When I delete the "John Doe" user
        Then the response should be successful
        And the user "John Doe" should have been deleted