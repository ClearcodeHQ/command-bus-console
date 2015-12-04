Feature: Handle command

  Scenario: Successfully handle command
    When I run command "command-bus:handle SuccessfulCommand"
    Then command should end successfully
     And the output should be
          """
          The SuccessfulCommand executed with success.
          """

  Scenario: Unsuccessfully handle command
    When I run command "command-bus:handle UnsuccessfulCommand"
    Then command should end unsuccessfully
     And the output should be
          """
          Unsuccessful command execution.
          """

  Scenario: Successfully handle command with argument
    When I run command "command-bus:handle CommandWithArgument 1234"
    Then command should end successfully
     And the output should be
          """
          The CommandWithArgument executed with success.
          """

  Scenario: Successfully handle command with named argument
    When I run command "command-bus:handle CommandWithArgument id=1234"
    Then command should end successfully
     And the output should be
          """
          The CommandWithArgument executed with success.
          """

  Scenario: Unsuccessfully handle command with argument if argument is missing
    When I run command "command-bus:handle CommandWithArgument"
    Then command should end unsuccessfully
     And the output should be
          """
          Missing argument 1 for 'CommandWithArgument' command.
          """

  Scenario: Unsuccessfully handle command with argument if argument has wrong name
    When I run command "command-bus:handle CommandWithArgument badName=1234"
    Then command should end unsuccessfully
    And the output should be
          """
          Missing argument 1 for 'CommandWithArgument' command.
          """