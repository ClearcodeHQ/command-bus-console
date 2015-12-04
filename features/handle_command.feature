Feature: Handle command

  Scenario: Successfully handle command
    When I run command "command-bus:handle SuccessfulCommand"
    Then command should end successfully
