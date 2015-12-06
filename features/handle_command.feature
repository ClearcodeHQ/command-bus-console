Feature: Handle command

  Scenario: Successfully handle command
    When I run command "command-bus:handle --no-interaction SuccessfulCommand"
    Then command should end successfully
     And the output should be
          """
          The tests\Clearcode\CommandBusConsole\CommandBus\SuccessfulCommand executed with success.
          """

  Scenario: Unsuccessfully handle command
    When I run command "command-bus:handle --no-interaction UnsuccessfulCommand"
    Then command should end unsuccessfully
     And the output should be
          """
          Unsuccessful command execution.
          """

  Scenario: Successfully handle command with argument
    When I run command "command-bus:handle --no-interaction CommandWithArgument --id=1234"
    Then command should end successfully
     And the output should be
          """
          The tests\Clearcode\CommandBusConsole\CommandBus\CommandWithArgument executed with success.
          """

  Scenario: Unsuccessfully handle command with argument if argument is missing
    When I run command "command-bus:handle --no-interaction CommandWithArgument"
    Then command should end unsuccessfully

  Scenario: Unsuccessfully handle command with argument if argument has wrong name
    When I run command "command-bus:handle --no-interaction CommandWithArgument --badName=1234"
    Then command should end unsuccessfully
