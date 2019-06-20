<?php
// CATCH
(bool) '1';
(bool) 1;
(int) '1';
(float) '1';
(bool) substr('aaa', 1);
(bool) random_bytes(6);

// DON'T CATCH
(bool) 1.1;
