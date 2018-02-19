<?php
// @codingStandardsIgnoreStart
// PHPUnit 6 compatibility

namespace PHPUnit\Framework {
    if (!interface_exists(Test::class, false)) {
        interface Test {
            public function run(TestResult $result = null);
        }

        interface SelfDescribing {
            public function toString();
        }

    }

}
// @codingStandardsIgnoreEnd