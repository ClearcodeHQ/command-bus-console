Feature: Interactive command

  Scenario: Run command in interactive mode
    When I run the command "DummyCommand" and I provide as input
    """
          1234 [enter]
    """
    Then the output should be
    """
        tests\Clearcode\CommandBusConsole\Bundle\Mocks\DummyCommand Object
        (
            [argument1] => 1234
        )
    """