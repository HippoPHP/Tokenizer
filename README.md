# Tokenizer

[![Build Status](http://img.shields.io/travis/HippoPHP/Tokenizer.svg?style=flat-square)](https://travis-ci.org/HippoPHP/Tokenizer)
[![Code Climate](http://img.shields.io/codeclimate/github/HippoPHP/Tokenizer.svg?style=flat-square)](https://codeclimate.com/github/HippoPHP/Tokenizer)
[![Test Coverage](http://img.shields.io/codeclimate/coverage/github/HippoPHP/Tokenizer.svg?style=flat-square)](https://codeclimate.com/github/HippoPHP/Tokenizer)
[![Dependencies](http://www.versioneye.com/user/projects/545df0edeb8df2273300003e/badge.svg?style=flat-square)](http://www.versioneye.com/user/projects/545df0edeb8df2273300003e)

## What is Tokenizer?

Tokenizer is a wrapper around the `token_get_all` function. It's built up of three classes:

1. `Token` - Each token returned from `token_get_all` is wrapped in this.
2. `TokenListIterator` - Implements `SeekableIterator` and `Countable` with extra methods to allow easy moving through tokens.
3. `Tokenizer` - Calls `token_get_all` on the source, turns each result into a `Token` representation and returns a `TokenListIterator` object.

# Installation

You can install Tokenizer by adding `hippophp/tokenizer` to your `composer.json` file.

# License

[MIT](/LICENSE.md)
