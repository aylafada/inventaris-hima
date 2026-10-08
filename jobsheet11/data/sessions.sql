CREATE TABLE IF NOT EXISTS sessions (
    id            VARCHAR(128) PRIMARY KEY,
    data          TEXT NOT NULL,
    last_activity BIGINT NOT NULL
);

CREATE INDEX IF NOT EXISTS sessions_last_activity_idx ON sessions (last_activity);

ALTER TABLE sessions ENABLE ROW LEVEL SECURITY;
REVOKE ALL ON TABLE sessions FROM anon, authenticated;
